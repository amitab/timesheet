<?php
/*
 *  Copyright 2012 Native5. All Rights Reserved 
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *	You may not use this file except in compliance with the License.
 *		
 *	You may obtain a copy of the License at
 *	http://www.apache.org/licenses/LICENSE-2.0
 *  or in the "license" file accompanying this file.
 *
 *	Unless required by applicable law or agreed to in writing, software
 *	distributed under the License is distributed on an "AS IS" BASIS,
 *	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *	See the License for the specific language governing permissions and
 *	limitations under the License.
 *
 */

/**
 * Application 
 * 
 * @category  Service Client Tests
 * @package   Native5\Tests
 * @author    Shamik Datta <shamik@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 */
namespace Native5\Tests;

use Native5\Configuration;
use Native5\Core\Log\LoggerFactory;
use Native5\Core\Log\Logger;

class Application {
    const N5_TESTS_NAME = 'Native5_Test';
    const N5_DEFAULT_LOG_LEVEL = 7;

    private static $_instance;
    private $_config;

    public static function init() {
        if (is_null(self::$_instance))
            $GLOBALS['app'] = new self();
    }

    private function __construct() {
        $configFile = __DIR__.'/../../config/settings.yml';
        if (!file_exists($configFile))
            throw new \Exception("No config file found in dummy Application");

        $this->_config = new Configuration($configFile);

        $logFileName = __DIR__.'/../../../logs/'.self::N5_TESTS_NAME.'-debug.log';
        $GLOBALS['logger'] = LoggerFactory::instance()->getLogger();
        $GLOBALS['logger']->addHandler($logFileName, Logger::ALL, 7);
    }

    public function getConfiguration() {
        return $this->_config;
    }
}

