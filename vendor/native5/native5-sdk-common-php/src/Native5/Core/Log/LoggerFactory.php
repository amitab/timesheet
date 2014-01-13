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
 * @category  Log 
 * @package   Native5\Core\Log 
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */
namespace Native5\Core\Log;

use Native5\Core\Log\Impl\MonologAdapter;

/**
 * LoggerFactory 
 * 
 * @category  Log 
 * @package   Native5\Core\Log 
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class LoggerFactory
{
    private static $_instance;
    private $_logAdapter;

    /**
     * Returns instance of Factory 
     * 
     * @access public
     * @return LoggerFactory 
     */
    public static function instance()
    {
        if (self::$_instance== null) {
            self::$_instance= new self;
        }

        return self::$_instance;
    }

    private function __construct()
    {
    }

    /**
     * Retrieves a concrete Logger 
     * 
     * @access public
     * @return @see Logger
     */
    public function getLogger()
    {
        $logger = new MonologAdapter();

        return $logger;
    }
}
