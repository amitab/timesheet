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

namespace Native5\Core;

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
abstract class YamlConfigFactory
{
    protected $_config;

    /**
     * __construct Construct a Yaml configuration
     * 
     * @param mixed $configFile The base (master) yaml configuration file
     * @access public
     * @return void
     */
    public function __construct($configFile) {
        $this->_config = $this->_parse($configFile);
    }

    /**
     * makeConfig Should wrap the associative array inside a getter/setter class
     * 
     * @abstract
     * @access public
     * @return void
     */
    abstract protected function makeConfig();

    /**
     * setOverridingConfig sets the local (override) configuration file
     * 
     * @param mixed $config path to local config file
     * @param mixed $strict whether to throw an exception if file is not found
     * @access public
     * @return void
     * @note needs to be called after setMasterConfig()
     */
    public function override($configFile, $strict = false) {
        $localConfig = $this->_parse($configFile, $strict);
        
        if (!empty($localConfig))
            $this->_config = array_replace_recursive($this->_config, $localConfig);
    }

    /**
     * getConfig get the merged configuration wrapped inside a Configuration class
     * 
     * @access public
     * @return void
     * @note should be called only after you have set your master and local configs
     */
    public function getConfig() {
        return $this->makeConfig();
    }

    /**
     * getRawConfig get the merged configuration as an associative array
     * 
     * @access public
     * @return void
     * @note should be called only after you have set your master and local configs
     */
    public function getRawConfig() {
        return $this->_config;
    }


    // ****** Private Functions Follow ****** //

    private function _parse($config, $exception = true) {
        $configArr = array();

        if ((empty($config) || !file_exists($config))) {
            if ($exception)
                throw new \Exception("Empty config file or file does not exist: ".$config);
            else
                return array();
        }

        if (!($configArr = @yaml_parse_file($config)) && $exception)
            throw new \Exception("Not a valid yaml file: ".$config);

        return $configArr;
    }
}

