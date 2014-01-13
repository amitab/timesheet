<?php
/**
 *  Copyright 2013 Native5. All Rights Reserved
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *	You may not use this file except in compliance with the License.
 *
 *	Unless required by applicable law or agreed to in writing, software
 *	distributed under the License is distributed on an "AS IS" BASIS,
 *	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *	See the License for the specific language governing permissions and
 *	limitations under the License.
 *  PHP version 5.3+
 *
 * @category  Configuration 
 * @package   Native5
 * @author    Shamik Datta <shamik@native5.com>
 * @copyright 2013 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5;

/**
 * Configuration
 * 
 * @category  Configuration 
 * @package   Native5
 * @author    Shamik Datta <shamik@native5.com>
 * @copyright 2013 Native5. All Rights Reserved
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class Configuration {
    private $_applicationContext;
    private $_apiUrl;
    private $_sharedKey;
    private $_secretKey;
    private $_defaultGrade;
    private $_logLevel;
    private $_local;

    public function __construct($applicationContext = null) {
        $this->_applicationContext = $applicationContext;
    }

    public function getApplicationContext() {
        return $this->_applicationContext;
    }

    public function setApplicationContext($applicationContext) {
        $this->_applicationContext = $applicationContext;
    }

    public function getApiUrl() {
        return $this->_apiUrl;
    }

    public function setApiUrl($apiUrl) {
        $this->_apiUrl = $apiUrl;
    }

    public function getSharedKey() {
        $sessionSharedKey = $GLOBALS['app']->getSessionManager()->getActiveSession()->getAttribute('sharedKey');
        if (!empty($sessionSharedKey))
            return $sessionSharedKey;
        return $this->_sharedKey;
    }

    public function setSharedKey($sharedKey) {
        $this->_sharedKey = $sharedKey;
    }

    public function getSecretKey() {
        $sessionSecretKey = $GLOBALS['app']->getSessionManager()->getActiveSession()->getAttribute('secretKey');
        if (!empty($sessionSecretKey))
            return $sessionSecretKey;
        return $this->_secretKey;
    }

    public function setSecretKey($secretKey) {
        $this->_secretKey = $secretKey;
    }

    public function getDefaultGrade() {
        return $this->_defaultGrade;
    }

    public function setDefaultGrade($defaultGrade) {
        $this->_defaultGrade = $defaultGrade;
    }

    public function getLogLevel() {
        return $this->_logLevel;
    }

    public function setLogLevel($logLevel) {
        $this->_logLevel = $logLevel;
    }

    public function isLocal() {
        return empty($this->_local) ? false : true;
    }

    public function setLocal() {
        $this->_local = true;
    }
}

