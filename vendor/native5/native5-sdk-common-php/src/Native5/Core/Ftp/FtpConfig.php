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

class FtpConfig {
    private $_host;
    private $_port;
    private $_user;
    private $_privateKey;
    private $_publicKey;

    public function getHost() {
        return $this->_host;
    }

    public function setHost($host) {
        $this->_host = $host;
    }

    public function getPort() {
        return $this->_port;
    }

    public function setPort($port) {
        $this->_port = $port;
    }

    public function getUser() {
        return $this->_user;
    }

    public function setUser($user) {
        $this->_user = $user;
    }

    public function getPrivateKey() {
        return $this->_privateKey;
    }

    public function setPrivateKey($privateKey) {
        $this->_privateKey = $privateKey;
    }

    public function getPublicKey() {
        return $this->_publicKey;
    }

    public function setPublicKey($publicKey) {
        $this->_publicKey = $publicKey;
    }

}

