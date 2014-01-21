<?php

namespace Timesheet\Group;

class Service {
	private $_data;
    private $_dao;

    /**
     * 
     * @var Singleton
     */
    private static $instance;

    private function __construct() {
        global $logger;
        $this->_data = array();
        $this->_dao = new \Timesheet\User\DAOImpl();
    }

    public static function getInstance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
	
	// The Cover
	
	public function getUserById($userId = null) {
		if($userId == null) return false;
		
		$data = $_dao->getUserById($userId);
		return $data;
	}
	
	
}