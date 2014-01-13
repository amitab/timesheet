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
 * @category  Log 
 * @package   Native5\Core\Log 
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Core\Log;

/**
 * Logger 
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
interface Logger
{
    const ALL = '/.*/';


    /**
     * Base method to log data.
     * 
     * - Supports Markdown
     * - Or maybe not
     *
     * ## Maybe a deciding criteria.
     *
     * @param mixed $message  String message with placeholders in printf format.
     * @param mixed $args     arguments for placeholder in message
     * @param mixed $priority Uses syslog priorities
     *
     * @access public
     * @return void
     */
    public function log($message, $args, $priority='LOG_INFO');


    /**
     * Helper method to log information at a priority level of INFO. 
     * e.g. @log(LOG_INFO, $message, $args)
     *
     * @param mixed $message : String message with placeholders in printf format.
     * @param mixed $args    : arguments for placeholder in message
     *
     * @access public
     * @return void
     */
    public function info($message, $args=array());


    /**
     * Helper method to log information at a priority level of DEBUG. 
     * e.g. @log(LOG_INFO, $message, $args)
     *
     * @param mixed $message : String message with placeholders in printf format.
     * @param mixed $args    : arguments for placeholder in message
     *
     * @access public
     * @return void
     */
    public function debug($message, $args=array());


    /**
     * Helper method to log information at a priority level of WARNING. 
     * e.g. @log(LOG_WARNING, $message, $args)
     *
     * @param mixed $message : String message with placeholders in printf format.
     * @param mixed $args    : arguments for placeholder in message
     *
     * @access public
     * @return void
     */
    public function warn($message, $args=array());


    /**
     * Helper method to log information at a priority level of ALERT. 
     * e.g. @log(LOG_ALERT, $message, $args)
     *
     * @param mixed $message : String message with placeholders in printf format.
     * @param mixed $args    : arguments for placeholder in message
     *
     * @access public
     * @return void
     */
    public function alert($message, $args=array());


    /**
     * Helper method to log information at a priority level of ERROR. 
     * e.g. @log(LOG_ERR, $message, $args)
     *
     * @param mixed $message : String message with placeholders in printf format.
     * @param mixed $args    : arguments for placeholder in message
     *
     * @access public
     * @return void
     */
    public function error($message, $args=array());


    /**
     * Routes messages matching a pattern to a particular channel/destination.
     *
     * @param mixed $destination For supported destinations see @LoggerDestination
     * @param mixed $pattern     `PCRE regex` pattern.
     * @param mixed $level       LOG LEVEL
     *
     * @access public
     * @return void
     */
    public function addHandler($destination, $pattern=Logger::ALL, $level='LOG_INFO');


}//end interface

