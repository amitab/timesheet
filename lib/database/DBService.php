<?php

namespace Database;

class DBService extends \Native5\Core\Database\DBDAO {
    
    protected $objectMaker;
    protected $tableHasPrimaryKey = true;
    
	public function __construct(\Native5\Core\Database\DB $db = null) {
        parent::__construct($db);
    }
	
	public function setObjectMaker($class, $methodName) {
	    $this->objectMaker = array( $class, $methodName );
	}
	
	public function tableHasPrimaryKey($tableHasPrimaryKey) {
	    $this->tableHasPrimaryKey = $tableHasPrimaryKey;
	}
	
	public function resetBoolean() {
	    $this->tableHasPrimaryKey = true;
	}
	
	private function _makeObject($temp_results) {
	    $results = array();
        foreach($temp_results as $res)
            $results[] = call_user_func( $this->objectMaker, $res ); 
        return $results;
	}
	
	// Executors
	
	protected function _executeObjectQuery($queryName, $parameterList, $queryType) {
		$temp_results = parent::execQuery($queryName, $parameterList, $queryType);
        if (!isset($temp_results[0]) || empty($temp_results[0])) {
            if($queryType == \Native5\Core\Database\DB::SELECT && empty($temp_results)) {
                $this->resetBoolean();
                return false;
            } else if(empty($temp_results) && $this->tableHasPrimaryKey) {
                throw new \Exception("Error executing Query.");
            }
        }

        if($queryType == \Native5\Core\Database\DB::SELECT) {
            $this->resetBoolean();
            return $this->_makeObject($temp_results);
        } else {
            $this->resetBoolean();
            return $temp_results;
        }

	}
	
	protected function _executeQuery($queryName, $parameterList, $queryType) {
		$temp_results = parent::execQuery($queryName, $parameterList, $queryType);
        
        if (!isset($temp_results[0]) || empty($temp_results[0])) {
            if($queryType == \Native5\Core\Database\DB::SELECT && empty($temp_results)) {
                $this->resetBoolean();
                return false;
            } else if(empty($temp_results) && $this->tableHasPrimaryKey) {
                throw new \Exception("Error executing Query.");
            }
        }
        
        $this->resetBoolean();
        return $temp_results;
	}
	
	protected function _executeObjectQueryString($queryString, $parameterList, $queryType) {
		$temp_results = parent::execQueryString($queryString, $parameterList, $queryType);
        if (!isset($temp_results[0]) || empty($temp_results[0])) {
            if($queryType == \Native5\Core\Database\DB::SELECT && empty($temp_results)) {
                $this->resetBoolean();
                return false;
                
            } else if(empty($temp_results) && $this->tableHasPrimaryKey) {
                throw new \Exception("Error executing Query.");
            }
        }

        if($queryType == \Native5\Core\Database\DB::SELECT) {
            $this->resetBoolean();
            return $this->_makeObject($temp_results);
        } else {
            $this->resetBoolean();
            return $temp_results;
        }
	}
	
	protected function _executeQueryString($queryString, $parameterList, $queryType) {
		
		$temp_results = parent::execQueryString($queryString, $parameterList, $queryType);
        if (!isset($temp_results[0]) || empty($temp_results[0])) {
            if($queryType == \Native5\Core\Database\DB::SELECT && empty($temp_results)) {
                $this->resetBoolean();
                return false;
            } else if(empty($temp_results) && $this->tableHasPrimaryKey) {
                throw new \Exception("Error executing Query. Result is empty.");
            }
        }
       
        $this->resetBoolean();
        return $temp_results;
	}
	
}

