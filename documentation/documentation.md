# Project Structure
-----------------------------

The folder timesheet is located in htdocs folder. So the root of this app would be: http://localhost/timesheet/

timesheet
|
+---cache
+---config
+---controllers
+---lib
+---models
\---views
    +---resources
    |   \---common
    |       +---.sass-cache
    |       +---images
    |       +---sass
    |       +---scripts
    |       \---styles
    \---templates
        \---common


## controllers : 
-----------------------------
All the controller php classes go here. They decide what is shown based on input data.

the common skeleton of a controller class : 

// replace <class name> with name of the file with first letter upper case. 
// Ex : if name of file = 'home.php', <class name> = 'Home'.
class <class name>Controller extends DefaultController 
{
	// default function called when URI is : http://localhost/timesheet/<class name>
	// $request : This variable has all the GET/POST variables sent from the client.
	// Each of the variables in this variable can be accessed using $request->getParam(<name of the variable>);
    public function _default($request) 
    {
		// Can be used for logging and debugging. 
		// syntax : $logger->log($message, $args, $priority='LOG_INFO');
		// The output is dumped to the text file in the 'logs' folder.
        global $logger; 
		//<html file> is the name of the html file which is in the 'views' folder.
        $skeleton =  new TwigRenderer(<html file>);
		//<response method> : 1. 'none' if output is html.
		//					  2. 'json' if output is json.
        $this->_response = new HttpResponse(<response method>, $skeleton);
        
        $this->_response->setBody(array(
            // Whatever variables that need to be passed to the output
			// (could be html file or json)
        ));

    }//end _default()
	
	// This method is called when URI is : http://localhost/timesheet/<method name>
	// You can make multiple methods like this.
	// Each of the methods that are to be accessible by the browser must be prefixed with an underscore '_' .
	// Ex : public function _method($request) {} can be accessed by localhost/timesheet/<class name>/<method name>
	public function _<method name>($request)
    {        
        // The structure of all the methods are the same.
    }
	
	// You can also have other private functions in the controller

}//end class

?>

## models : 
-----------------------------

This folder contains all the files which represent the structure of the tables in the MYSQL Database. 
These php files are basically classes with variables which correspond to the columns in the Database Table along with its getters and setters 
(you could also have validation functions).

NOTE: If you have private variables in the class, then you must extract the variables into an associative array before sending data in json format. 
In the case of twig, its not necessary. It automatically calls the object's getters while accessing it.

To make things easier, you could have a static function which accepts an associative array(from the database query) and constructs an object out of the data.

Ex : 

class User {
	private $userId;
	private $userLocation;
	private $userMail;
	
	public static function make($data) {
		$user = new self();
		$user->setUserId($data['user_id']);
		$user->setUserLocation($data['user_location']);
		$user->setUserMail($data['user_email']);
		return $user;
	}
	
	public function setUserId($userId) { $this->userId = $userId; }
	public function getUserId() { return $this->userId; }
	
	public function setUserLocation($userLocation) { $this->userLocation = $userLocation; }
	public function getUserLocation() { return $this->userLocation; }
	
	public function setUserMail($userMail) { $this->userMail = $userMail; }
	public function getUserMail() { return $this->userMail; }
	
	// validation
	
	public static function validateEmail($email) {
		if (filter_var($email_a, FILTER_VALIDATE_EMAIL)) {
			return true;
		}
		return false;
	}
	
}

## libs : 
-----------------------------

This folder contains all the database access codes. 
Each entity has a DAO, DAO Implementation and a Service class.
DAO is the interface which declares all the possible methods of interaction with the database.
DAOImpl implements the DAO and must extend \Native5\Core\Database\DBDAO.
You could also extend the \Native5\Core\Database\DBDAO to another class and tune it to you requirements and use this to extend your DAOImpl classes.
Service class is a wrapper around the DAOImpl class. Service class will have an instance of the DAOImpl class.

queries.cfg.yml contains all the named queries which are to be called through the execQuery() method of \Native5\Core\Database\DBDAO.
You could also construct a query and use execQueryString() method of \Native5\Core\Database\DBDAO.

public function getUserById($userId) {
	$valArr = array(
		':userId' => $userId
	);
	
	// $valArr is an associative array with all the parameters required by the query. 
	// 'find user by id' is a named query present in the queries.cfg.yml file. 
	// ex: find user by id : SELECT `user`.* FROM `user` where `user`.`user_id` = :userId;
	// The third argument refers to the type of the query. The other possible values are : 
	// \Native5\Core\Database\DB::UPDATE, \Native5\Core\Database\DB::DELETE, \Native5\Core\Database\DB::INSERT
	
	$data = parent::execQuery('find user by id', $valArr, \Native5\Core\Database\DB::SELECT);
	return $data;
} 

Also while inserting, you may want to modify/insert more data in the database. In that case you will need to have all the database access function between
startTransaction() and commitTransaction() / rollBackTransaction().

public function createTimesheet($timesheetDetails) {
	$valArr = array(
		':timesheetProjectName' => $timesheetDetails->getTimesheetProjectName(),
		':timesheetDate' => $timesheetDetails->getTimesheetDate(),
	);
	
	try {
		// db is a variable in the parent class
		$this->db->beginTransaction();
		
		// Need current insert ID
		$timesheetId = parent::execQuery('create new timesheet', $valArr, \Native5\Core\Database\DB::INSERT); 
		
		// Inserting into the association tables
		$sql = 'INSERT INTO `user_timesheet` (timesheet_id, user_id) VALUES (' . 
		$timesheetId . ', ' . $timesheetDetails->getUserId . ');';
		$sql .= 'INSERT INTO `project_timesheet` (timesheet_id, project_id) ' .
		'VALUES (' . $timesheetId . ', ' . $timesheetDetails->getProjectId . ');';
		
		parent::execQueryString($sql, null, \Native5\Core\Database\DB::INSERT);
		
		$this->db->commitTransaction();
		
	} catch (\Exception $e) {
		$GLOBALS['logger']->info( 'Could not create timesheet' . $e->getMessage());
		$this->db->rollbackTransaction();
		return false;
	} 
	
	return $timesheetId;
}

## views : 
-----------------------------

As seen in the project structure, views has 2 directories: resources and templates
resources contains all the stylesheets, scripts, images.
templates have all the html files.

Templates are rendered by twig renderer in the controller. 
In the controller, the associative array passed to $this->_response->setBody() is available to the template.
More about twig in http://twig.sensiolabs.org/