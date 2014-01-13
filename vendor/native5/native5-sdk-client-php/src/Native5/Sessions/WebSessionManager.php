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
 * @category  Sessions 
 * @package   Native5\Sessions
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Sessions;

/**
 * SessionManager
 * 
 * @category  Sessions 
 * @package   Native5\Sessions
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class WebSessionManager implements SessionManager
{

    const GLOBAL_PREFIX = 'native5.';

    private $_session;


    /**
     * startSession 
     * 
     * @param mixed $context     SessionContext 
     * @param mixed $useExisting Whether to use existing session.
     *
     * @access public
     * @return void
     */
    public function startSession($context=null, $useExisting=false)
    {
        $logger = $GLOBALS['logger'];
        if ($useExisting === true) {
            session_name('_n5_session');
            session_start();
            $this->_session = new Session($_SESSION);
            if ($this->_session->getAttribute('category') !== null) {
                return;
            }
        }

        if (!isset($_SESSION[self::GLOBAL_PREFIX.'category'])) {
            // No session exists yet.
            if ($context === null) {
                $context = new WebContext($_REQUEST);
            }

            session_unset();
            session_destroy();
            session_set_cookie_params(0, '/', '', false, true);
            session_name('_n5_session');
            session_start();
            session_regenerate_id();
            $_SESSION = array();

            $app = $GLOBALS['app'];
            if (!$app->getConfiguration()->isLocal()) {
                //$handler = new CachedSessionHandler();
                //session_set_save_handler(
                    //array($handler, 'open'),
                    //array($handler, 'close'),
                    //array($handler, 'read'),
                    //array($handler, 'write'),
                    //array($handler, 'destroy'),
                    //array($handler, 'gc')
                //);
            }

            $_SESSION[self::GLOBAL_PREFIX.'category']      = $context->get('device');
            $_SESSION[self::GLOBAL_PREFIX.'location']      = $context->get('location');
            $_SESSION[self::GLOBAL_PREFIX.'last_accessed'] = time();
        }//end if

        $this->_session = new Session($_SESSION);

    }//end startSession()


    /**
     * getSession  
     * 
     * @param mixed $id The id using which to query the session.
     *
     * @access public
     * @return void
     */
    public function getSession($id)
    {
        return $this->_session;

    }//end getSession()


    /**
     * endSession 
     * 
     * @param mixed $id Ending the session. 
     *
     * @access public
     * @return void
     */
    public function endSession($id)
    {
        // TODO: End Session corresponding to Session ID

    }//end endSession()


    /**
     * Gets the currently active session. 
     * 
     * @access public
     * @return Session
     */
    public function getActiveSession()
    {
        return $this->_session;

    }//end getActiveSession()


    /**
     * Checks if session is currently active.
     * 
     * @access public
     * @return boolean
     */
    public function isActiveSession()
    {
        if(isset($_SESSION[self::GLOBAL_PREFIX.'last_accessed']) &&
            (time() - $_SESSION[self::GLOBAL_PREFIX.'last_accessed'] > SESSION_TIMEOUT)) {
                return FALSE;	
            }
        return TRUE;

    }//end isActiveSession()


    /**
     * Resets currently active session. 
     * 
     * @access public
     * @return void
     */
    public static function resetActiveSession()
    {
        $category = $_SESSION[self::GLOBAL_PREFIX.'category'];
        session_unset();
        session_destroy();
        session_start();
        session_regenerate_id();
        $_SESSION = array();
        $_SESSION[self::GLOBAL_PREFIX.'category']      = $category; 
        $_SESSION[self::GLOBAL_PREFIX.'last_accessed'] = time();

    }//end resetActiveSession()


    /**
     * updateActiveSession 
     * 
     * @access public
     * @return void
     */
    public static function updateActiveSession()
    {
        $_SESSION[self::GLOBAL_PREFIX.'last_accessed'] = time();

    }//end updateActiveSession()


}//end class

?>
