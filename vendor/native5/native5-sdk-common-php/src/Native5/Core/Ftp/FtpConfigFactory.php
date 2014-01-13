<?php
/**
 *  Copyright 2013 Native5. All Rights Reserved
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
 * @copyright 2013 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */

namespace Native5\Core\Ftp;

use Native5\Core\YamlConfigFactory;

class FtpConfigFactory extends YamlConfigFactory {
    protected $_baseDir;
    protected $_configuration;

    /**
     * __construct Construct a FtpConfigFactory
     * 
     * @param string $configFile        Absolute path to master configuration file
     * @param string $localConfigFile   Absolute path to local configuration file
     * @param string $baseDir           Base directory relative to which paths to private/public key files will be resolved (default: cwd)
     *
     * @access public
     * @return object FtpConfigFactory instance
     *
     * @note the ftp configuration file should be of the following format:
     *     ftp:
     *         host: '<your ftp host>'
     *         port: '<port on which ftp service is running (default 22)>'
     *         user: '<ftp username>'
     *         private_key: '<path to ssh private key file relative to baseDir>'
     *         public_key: '<path to ssh public key file relative to baseDir>'
     */
    public function __construct($configFile, $localConfigFile = null, $baseDir = null) {
        parent::__construct($configFile);
        parent::override($localConfigFile);

        // Set the base directory
        if (!empty($baseDir)) {
            if (!file_exists($baseDir) || !is_dir($baseDir))
                throw new \Exception("Received baseDir does not exist or is not a directory: $baseDir");

            $this->_baseDir = $baseDir;
        } else {
            $this->_baseDir = getcwd();
        }
    }
    
    /**
     * makeConfig Wrap the associative configuration array inside a DBConfig class
     * 
     * @access public
     * @return void
     */
    protected function makeConfig() {
        $this->_checkConfig();

        // Construct the DBConfig object
        $ftpConfig = new FtpConfig();
        $ftpConfig->setHost($this->_config['host']);
        $ftpConfig->setPort($this->_config['port']);
        $ftpConfig->setUser($this->_config['user']);
        $ftpConfig->setPrivateKey($this->_baseDir.'/'.$this->_config['private_key']);
        $ftpConfig->setPublicKey($this->_baseDir.'/'.$this->_config['public_key']);

        return $ftpConfig;
    }

    // ****** Private Functions Follow ****** //

    private function _checkConfig() {
        // Ftp configuration can be namespaced with the 'ftp' keyword
        if (isset($this->_config['ftp']))
            $this->_config = $this->_config['ftp'];

        // Check each configuration entry
        if (empty($this->_config) || !is_array($this->_config))
            throw new \InvalidArgumentException("Configuration should be an array");
        else if (empty($this->_config['host']))
            throw new \InvalidArgumentException("Ftp server host not specified in configuration");
        else if (empty($this->_config['port']))
            throw new \InvalidArgumentException("Ftp server port not specified in configuration");
        else if (empty($this->_config['user']))
            throw new \InvalidArgumentException("Ftp user not specified in configuration");
        else if (empty($this->_config['private_key']))
            throw new \InvalidArgumentException("Ftp user ssh private key not specified in configuration");
        else if (!is_readable($this->_baseDir.'/'.$this->_config['private_key']))
            throw new \InvalidArgumentException("Ftp user ssh private key not found or not readable at: ".$this->_baseDir.'/'.$this->_config['private_key']);
        else if (empty($this->_config['public_key']))
            throw new \InvalidArgumentException("Ftp user ssh public key not specified in configuration");
        else if (!is_readable($this->_baseDir.'/'.$this->_config['public_key']))
            throw new \InvalidArgumentException("Ftp user ssh public key not found or not readable at: ".$this->_baseDir.'/'.$this->_config['public_key']);
    }
}

