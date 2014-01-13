<?php
/**
 *  Copyright 2012 Native5. All Rights Reserved
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  You may not use this file except in compliance with the License.
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *  PHP version 5.3+
 *
 * @category  Connectors
 * @package   Native5\Core\Connectors\Database
 * @author    Shamik Datta <shamik@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */

namespace Native5\Core\Database;

use Native5\Core\Caching\Cache;

/**
 * DBHelper
 */
class DBHelper {
    /**
     * Constant indicating execution of a SELECT query 
     *
     * @access public
     */
    const SELECT = 0;
    /**
     * Constant indicating execution of an INSERT query 
     *
     * @access public
     */
    const INSERT = 1;
    /**
     * Constant indicating execution of an UPDATE query 
     *
     * @access public
     */
    const UPDATE = 2;
    /**
     * Constant indicating execution of a DELETE query 
     *
     * @access public
     */
    const DELETE = 3;

    protected $_con;
    protected $_statementCache;

    /**
     * __construct  Create a DBHelper instance
     * 
     * @param object PDO object
     *
     * @access public
     * @return object instance of DBHelper object
     */
    public function __construct(\PDO $db) {
        $this->_con = $db;
        $this->_statementCache = new Cache();
    }

    /**
     * __destruct Releases DB connection
     * 
     * @access public
     * @return void
     */
    public function __destruct() {
        unset($this->_con);
        $this->_con = null;
    }

    /**
     * getConnection Returns the PDO connection instance
     * 
     * @access public
     * @return object PDO object for the DB Connection
     */
    public function getConnection() {
        return $this->_con;
    }

    /**
     * prepare Prepare query from sql query
     * 
     * @param string $sql SQL query string
     *
     * @access public
     * @return object prepared statement
     * @throws Exception if statement could not be prepared successfuly
     */
    public function prepare($sql) {
        $sqlKey = md5($sql);
        if ($this->_statementCache->exists($sqlKey))
            return $this->_statementCache->get($sqlKey);

        try {
            $statement = $this->_con->prepare($sql);
        } catch (\PDOException $pe) {
            throw new \Exception("Error in preparing statement:: query: ".$sql.PHP_EOL."Message: ".$pe->getMessage());
        }

        $this->_statementCache->set($sqlKey, $statement);
        return $statement;
    }

    /**
     * bindValues Bind values to a prepared statement
     * 
     * @param object $statement PDOStatement object
     * @param array $valArr array with statment placeholders mapped to values to bind
     *
     * @access public
     * @return object prepared statement with bound values
     * @throws Exception if could not bind parameter to statement successfuly
     */
    public function bindValues (\PDOStatement $statement, $valArr = array()) {
        if (empty($valArr))
            return $statement;

        // Bind the values
        foreach ($valArr as $key=>$val) {
            try {
                $statement->bindValue($key, $val);
            } catch (\PDOException $pe) {
                echo "Error in binding parameter: ".$pe->getMessage();
            }
        }

        return $statement;
    }

    /**
     * beginTransaction Begin database transaction
     * 
     * @access public
     * @return void
     * @throws Exception if already inside a transaction of if could not begin transaction successfuly
     */
    public function beginTransaction() {
        // check if a transaction is already active
        if ($this->_con->inTransaction())
            throw new \Exception("Already inside a DB transaction. You need to commit it before beginning a new one.");

        try {
            $this->_con->beginTransaction();
        } catch (Exception $_e) {
            throw new \Exception("Error while beginning DB transaction: ".$pe->getMessage());
        }
    }

    /**
     * commitTransaction Commit begun database transaction
     * 
     * @access public
     * @return void
     * @throws Exception if not inside a transaction of if could not commit transaction successfuly
     */
    public function commitTransaction() {
        // check that a transaction is really active
        if (!$this->_con->inTransaction())
            throw new \Exception("Not inside a DB transaction. Cannot commit.");

        try {
            $this->_con->commit();
        } catch (Exception $_e) {
            throw new \Exception("Error while committing DB transaction: ".$pe->getMessage());
        }
    }

    /**
     * rollBackTransaction Rollback begun database transaction
     * 
     * @access public
     * @return void
     * @throws Exception if not inside a transaction of if could not rollback transaction successfuly
     */
    public function rollBackTransaction() {
        // check that a transaction is really active
        if (!$this->_con->inTransaction())
            throw new \Exception("Not inside a DB transaction. Cannot commit.");

        try {
            $this->_con->rollBack();
        } catch (Exception $_e) {
            throw new \Exception("Error while rolling back DB transaction: ".$pe->getMessage());
        }
    }

    /**
     * exec Execute prepared statement on this database, reconnects to DB if connection does not exist
     * 
     * @param object $query PDO prepared statement to execute
     * @param mixed $type Type of database query - refer class constants
     * @param boolean $reconnect true if should reconnect to DB on a connection failure, false otherwise
     * @access public
     * @return array|int|boolean SELECT - array of all selected rows as associative arrays on success, throws exception otherwise
     *                           INSERT- Database ID for inserted row, throws exception otherwise
     *                           UPDATE | DELETE- true on success, throws exception otherwise
     * @throws Exception if could not execute the query successfuly
     */
    public function exec(\PDOStatement $statement, $type = self::SELECT) {
        // Execute
        try {
            $statement->execute();
        } catch (\PDOException $pe) {
            $statement->closeCursor();
            throw new \Exception("Error while executing query: ".$pe->getMessage());
        }

        // Process Result based on the query type
        if ($type == self::SELECT) {
            $result = array();
            foreach($statement as $row) {
                $result[] = $row;
            }
        } else if ($type == self::INSERT) {
            $result = (int)$this->_con->lastInsertId();
        } else {
            $result = true;
        }

        $statement->closeCursor();

        return $result;
    }

    /**
     * execQuery Wrapper method which prepares the query, binds values and executes it
     * 
     * @param mixed $query Query string
     * @param array $valArr array with statment placeholders mapped to values to bind
     * @param mixed $queryType Type of database query - refer class constants
     *
     * @return array|int|boolean SELECT - array of all selected rows as associative arrays on success, throws exception otherwise
     *                           INSERT- Database ID for inserted row, throws exception otherwise
     *                           UPDATE | DELETE- true on success, throws exception otherwise
     * @throws Exception if could not prepare statement, or bind values or execute query successfuly
     */
    public function execQuery($query, $valArr = array(), $queryType = self::SELECT) {
        return $this->exec($this->bindValues($this->prepare($query), $valArr), $queryType);
    }

}
