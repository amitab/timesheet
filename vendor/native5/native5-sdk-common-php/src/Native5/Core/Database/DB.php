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
 * @category  Sessions
 * @package   Native5\Core\Connectors\Database
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */

namespace Native5\Core\Database;

/**
 * DB 
 *
 * @category  Connectors 
 * @package   Native5\Core\Connectors\Database
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0
 * @link      http://www.docs.native5.com
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class DB
{

    private static $_dbs;

    /**
     * Factory method for instantiating a db object
     * 
     * @static
     * @access public
     * @return void
     */
    public static function factory(DBConfig $configuration)
    {
        return self::instance($configuration);
    }//end factory()

    /**
     * instance 
     * 
     * @param mixed $configuration Database configuration
     *
     * @static
     * @access private
     * @return void
     */
    private static function instance(DBConfig $configuration, $renew = false)
    {
        $port = $configuration->getPort();
        $port = !empty($port) ? $port : 3306;
        $dsn = $configuration->getType().':host='.$configuration->getHost().';port='.$port.';dbname='.$configuration->getName();
        $dbKey = md5($dsn.'.'.$configuration->getUser());

        if (!$renew && isset(self::$_dbs[$dbKey]) && !empty(self::$_dbs[$dbKey]))
            return self::$_dbs[$dbKey];

        if (empty($configuration))
            throw new \Exception('Empty connection settings provided'); 

        // Create a PDO Instance for this user + database combination
        try {
            self::$_dbs[$dbKey] = new \PDO($dsn, $configuration->getUser(), $configuration->getPassword());
        } catch(\PDOException $pe) {
            throw new \RuntimeException("Cannot connect to DB '".$configuration->getName()."' with user '".$configuration->getUser()."'".PHP_EOL.
                    "Message: ".$pe->getMessage());
        }

        self::$_dbs[$dbKey]->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        self::$_dbs[$dbKey]->setAttribute(\PDO::ATTR_PERSISTENT, true);
        self::$_dbs[$dbKey]->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        self::$_dbs[$dbKey]->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'UTF8'");
        self::$_dbs[$dbKey]->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        self::$_dbs[$dbKey]->setAttribute(\PDO::ATTR_ORACLE_NULLS, \PDO::NULL_TO_STRING);
        self::$_dbs[$dbKey]->setAttribute(\PDO::ATTR_EMULATE_PREPARES, 1);

        return self::$_dbs[$dbKey];
    }//end instance()


    private function __construct() {}

}//end class

