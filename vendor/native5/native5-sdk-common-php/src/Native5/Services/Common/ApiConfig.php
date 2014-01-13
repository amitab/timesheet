<?php
/**
 *  Copyright 2012 Native5. All Rights Reserved
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
 * @category  <category> 
 * @package   Native5\Core\<package>
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Services\Common;

class ApiConfig {

    protected static $_instance;
    protected $_apiUrl;

    protected function __construct($configFile) {
        if (!empty($configFile) && file_exists($configFile)) {
            $configOpts = yaml_parse_file($configFile);
            $this->_apiUrl = $configOpts['url'];
        } else {
            $this->_apiUrl = self::BASE_URL; 
        }
    }

    public static function instance($configFile='config/settings.yml')
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new self($configFile);
        }
        return self::$_instance;
    }

    public function getApiUrl() {
        return $this->_apiUrl;
    }
}

