# Project Structure
-----------------------------

## controllers : 
-----------------------------
All the controller php classes go here. They decide what is shown based on input data.

the common skeleton of a controller class : 

// replace <class name> with name of the file with first letter upper case. 
// Ex : if name of file = 'home.php', <class name> = 'Home'.
class <class name>Controller extends DefaultController 
{
	// default function called when URI is : localhost/timesheet/<class name>
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
	
	// This method is called when URI is : localhost/timesheet/<method name>
	// You can make multiple methods like this.
	// Each of the methods that are to be accessible by the browser must be prefixed with an underscore '_' .
	// Ex : public function _method($request) {} can be accessed by localhost/timesheet/<class name>/<method name>
	public function _<method name>($request)
    {        
        // The structure of all the methods are the same.
    }

}//end class

?>

## views : 
-----------------------------
