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
 * @package   Native5\Core\Log\Impl 
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Core\Log\Impl;

use Native5\Core\Log\Logger;
use Native5\Core\Log\Impl\FileLogHandler;

/**
 * Abstract logger providing base framework in which all Logger implementations work.
 * 
 * @category  Log 
 * @package   Native5\Core\Log\Impl 
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
abstract class AbstractLogAdapter implements Logger
{

    protected $logPatterns;


    /**
     * Public constructor 
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->_logPatterns = array();

    }//end __construct()


    /**
     * Gets handler corresponding to a destination 
     * 
     * @param mixed $destination Destination  
     * 
     * @abstract
     * @access protected
     * @return void
     */
    abstract protected function getHandler($destination, $level);


    /**
     * Implementation of `log` method in Logger 
     * 
     * @param mixed $message  Message to log 
     * @param mixed $args     Arguments to message
     * @param mixed $priority Priority of message
     * 
     * @access public
     * @return void
     */
    public function log($message, $args, $priority='LOG_INFO')
    {
        if (array_key_exists('FILENAME', $args) === false) {
            $backtrace        = debug_backtrace();
            $args['FILENAME'] = $backtrace[0]['file'];
            $args['LINENO']   = $backtrace[0]['line'];
        }//end if

        $newArgs   = array();
        $fileParts = explode('/', $args['FILENAME']);
        $newArgs[] = array_pop($fileParts);
        $newArgs[] = $args['LINENO'];
        unset($args['LINENO']);
        unset($args['FILENAME']);
        foreach ($args as $arg) {
            $newArgs[] = $arg;
        }//end foreach

        // Escaping any % in the message before passing to vsprintf
        $message = str_replace('%', '%%', $message);

        $message = '[%s,%d] : '.$message;
        $msg     = vsprintf($message, $newArgs);
        if ($this->_isSecure($msg) === true) {
            // TODO: Do not write log
            // Get list of handlers which will process message
            // Send message about which handlers are erroneous.
        } else {
            if (empty($this->_logPatterns)) {
                $this->_logPatterns[Logger::ALL]
                    = new FileLogHandler();
            }//end if

            foreach ($this->_logPatterns as $pattern => $handler) {
                if(preg_match($pattern, $msg))
                    $handler->writeLog($msg, $priority);
            }//end foreach
        }

    }//end log()


    /**
     * Implementation of Info in Logger 
     * 
     * @param mixed $message Message to log 
     * @param mixed $args    Arguments to message
     * 
     * @access public
     * @return void
     */
    public function info($message, $args=array())
    {
        $backtrace        = debug_backtrace();
        $args['FILENAME'] = $backtrace[0]['file'];
        $args['LINENO']   = $backtrace[0]['line'];
        $this->log($message, $args, 'LOG_INFO');

    }//end info()


    /**
     * Implementation of debug in Logger 
     * 
     * @param mixed $message Message to log 
     * @param mixed $args    Arguments to message
     * 
     * @access public
     * @return void
     */
    public function debug($message, $args=array())
    {
        $backtrace        = debug_backtrace();
        $args['FILENAME'] = $backtrace[0]['file'];
        $args['LINENO']   = $backtrace[0]['line'];
        $this->log($message, $args, 'LOG_DEBUG');

    }//end debug()


    /**
     * Implementation of warn in Logger 
     * 
     * @param mixed $message Message to log 
     * @param mixed $args    Arguments to message
     * 
     * @access public
     * @return void
     */
    public function warn($message, $args=array())
    {
        $backtrace        = debug_backtrace();
        $args['FILENAME'] = $backtrace[0]['file'];
        $args['LINENO']   = $backtrace[0]['line'];
        $this->log($message, $args, 'LOG_WARNING');

    }//end warn()


    /**
     * Implementation of error in Logger 
     * 
     * @param mixed $message Message to log 
     * @param mixed $args    Arguments to message
     * 
     * @access public
     * @return void
     */
    public function error($message, $args=array())
    {
        $backtrace        = debug_backtrace();
        $args['FILENAME'] = $backtrace[0]['file'];
        $args['LINENO']   = $backtrace[0]['line'];
        $this->log($message, $args, 'LOG_ERR');

    }//end error()


    /**
     * Implementation of alert in Logger 
     * 
     * @param mixed $message Message to log 
     * @param mixed $args    Arguments to message
     * 
     * @access public
     * @return void
     */
    public function alert($message, $args=array())
    {
        $backtrace        = debug_backtrace();
        $args['FILENAME'] = $backtrace[0]['file'];
        $args['LINENO']   = $backtrace[0]['line'];
        $this->log($message, $args, 'LOG_ALERT');

    }//end alert()


    /**
     * Implementation of addHandler in Logger 
     * 
     * @param mixed $destination Destination to which to send handler to 
     * @param mixed $pattern     Regex pattern 
     * 
     * @access public
     * @return void
     */
    public function addHandler($destination, $pattern=Logger::ALL, $level='LOG_INFO')
    {
        $this->_logPatterns[$pattern] = $this->getHandler($destination, $level);

    }//end addHandler()


    /**
     * _isSecure 
     * 
     * @param mixed $message Message to check
     *
     * @access private
     * @return void
     */
    private function _isSecure($message)
    {
        // TODO: Check if matches security Pattern.
        return false;

    }//end _isSecure()


}//end class

?>
