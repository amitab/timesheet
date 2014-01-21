<?php

namespace Database;

class DBService extends \Native5\Core\Database\DBDAO {

	public function __construct(\Native5\Core\Database\DB $db = null) {
        parent::__construct($db);
    }
	
	public function getRecentInsertId() {
		return mysql_insert_id($db->getConnection());
	}
	
}

?>
