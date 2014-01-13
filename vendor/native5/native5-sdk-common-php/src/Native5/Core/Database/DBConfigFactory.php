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

use Native5\Core\YamlConfigFactory;

class DBConfigFactory extends YamlConfigFactory {

    /**
     * makeConfig Wrap the associative configuration array inside a DBConfig class
     * 
     * @access public
     * @return void
     * @note the Database configuration should be of the following format:
     *  mixed[] $configuration {
     *     @type string "type" Database type as used in PDO DSN
     *     @type string "host" Database host
     *     @type string "host" Database port
     *     @type integer "name" Database name
     *     @type boolean "username" Database username
     *     @type string "password" Database password
     * }
     */
    protected function makeConfig() {
        $this->_checkConfig();

        // Construct the DBConfig object
        $dbConfig = new DBConfig();
        $dbConfig->setName($this->_config['name']);
        $dbConfig->setType($this->_config['type']);
        $dbConfig->setHost($this->_config['host']);
        if (isset($this->_config['port']))
            $dbConfig->setPort($this->_config['port']);
        $dbConfig->setUser($this->_config['user']);
        $dbConfig->setPassword($this->_config['password']);

        return $dbConfig;
    }

    private function _checkConfig() {
        // Database configuration can be namespaced with the 'database' keyword
        if (isset($this->_config['database']))
            $this->_config = $this->_config['database'];

        // Check each configuration entry
        if (empty($this->_config) || !is_array($this->_config))
            throw new \InvalidArgumentException("Configuration should be an array");
        else if (empty($this->_config['type']))
            throw new \InvalidArgumentException("DB type not specified in configuration");
        else if (empty($this->_config['host']))
            throw new \InvalidArgumentException("DB host not specified in configuration");
        else if (empty($this->_config['name']))
            throw new \InvalidArgumentException("DB name not specified in configuration");
        else if (empty($this->_config['user']))
            throw new \InvalidArgumentException("DB username not specified in configuration");
        else if (empty($this->_config['password']))
            throw new \InvalidArgumentException("DB password not specified in configuration");
    }
}

