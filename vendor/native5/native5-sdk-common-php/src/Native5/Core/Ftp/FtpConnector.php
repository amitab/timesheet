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

class FtpConnector {
    private $_config;
    private $_session;

    public function __construct(FtpConfig $config) {
        $this->_config = $config;
        $this->_session = ssh2_connect($this->_config->getHost(), $this->_config->getPort());
        if (!ssh2_auth_pubkey_file(
            $this->_session,
            $this->_config->getUser(),
            $this->_config->getPublicKey(),
            $this->_config->getPrivateKey()
        ))
            throw new \Exception("Could not connect to Ftp server with provided configuration");
    }

    public function send($fileData, $fileName) {
        $ssh2Wrapper = 'ssh2.sftp://'.$this->_session.$fileName;
        if (@file_put_contents($ssh2Wrapper, $fileData))
            return true;
        else
            return false;
    }

    public function receive($fileName) {
        $ssh2Wrapper = 'ssh2.sftp://'.$this->_session.$fileName;
        return @file_get_contents($ssh2Wrapper);
    }
}

