<?php

namespace Database;

class DBService extends \Native5\Core\Database\DBDAO {
    
    protected $objectMaker;
    
	public function __construct(\Native5\Core\Database\DB $db = null) {
        parent::__construct($db);
    }
	
	public function setObjectMaker($class, $methodName) {
	    $this->objectMaker = array( $class, $methodName );
	}
	
	// Executors
	
	protected function _executeObjectQuery($queryName, $parameterList, $queryType) {
		$temp_results = parent::execQuery($queryName, $parameterList, $queryType);
        if (empty($temp_results) || !isset($temp_results[0]) || empty($temp_results[0])) {
            if($queryType == \Native5\Core\Database\DB::SELECT) {
                return false;
            } else {
                throw new \Exception("Error executing Query.");
            }
        }

        if($queryType == \Native5\Core\Database\DB::SELECT) {
            $results = array();
            foreach($temp_results as $res)
                $results[] = call_user_func( $objectMaker, $res ); 
            return $results;
        } else {
            return $temp_results;
        }

	}
	
	protected function _executeQuery($queryName, $parameterList, $queryType) {
		$temp_results = parent::execQuery($queryName, $parameterList, $queryType);
        if (empty($temp_results) || !isset($temp_results[0]) || empty($temp_results[0])) {
            if($queryType == \Native5\Core\Database\DB::SELECT) {
                return false;
            } else {
                throw new \Exception("Error executing Query.");
            }
        }
        
        return $temp_results;
	}
	
	protected function _executeObjectQueryString($queryString, $parameterList, $queryType) {
		$temp_results = parent::execQuery($queryString, $parameterList, $queryType);
        if (empty($temp_results) || !isset($temp_results[0]) || empty($temp_results[0])) {
            if($queryType == \Native5\Core\Database\DB::SELECT) {
                return false;
            } else {
                throw new \Exception("Error executing Query.");
            }
        }

        if($queryType == \Native5\Core\Database\DB::SELECT) {
            $results = array();
            foreach($temp_results as $res)
                $results[] = call_user_func( $objectMaker, $res ); 
            return $results;
        } else {
            return $temp_results;
        }
	}
	
	protected function _executeQueryString($queryString, $parameterList, $queryType) {
		$temp_results = parent::execQuery($queryString, $parameterList, $queryType);
        if (empty($temp_results) || !isset($temp_results[0]) || empty($temp_results[0])) {
            if($queryType == \Native5\Core\Database\DB::SELECT) {
                return false;
            } else {
                throw new \Exception("Error executing Query.");
            }
        }
        
        return $temp_results;
	}
	
}

?>
