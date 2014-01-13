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
 * @category  Security
 * @package   Native5\Security
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */
namespace Native5\Identity;

/**
 * SecurityUtils 
 * 
 * @category  Security
 * @package   Native5\Security
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class SecurityUtils
{

    private static $_securityManager;


    /**
     * setSecurityManager Sets the security manager 
     * 
     * @param mixed $sm SecurityManager
     *
     * @static
     * @access public
     * @return void
     */
    public static function setSecurityManager($sm)
    {
        self::$_securityManager = $sm;

    }//end setSecurityManager()


    /**
     * getSecurityManager Gets the security Manager 
     * 
     * @static
     * @access public
     * @return void
     */
    public static function getSecurityManager()
    {
        return self::$_securityManager;

    }//end getSecurityManager()


    /**
     * getSubject Convienience method to retrieve the subject. 
     * Subject is always retrieved from applicationContext.
     * If no subject is found, then a new subject is created with default properties.
     * 
     * @static
     * @access public
     * @return void
     */
    public static function getSubject()
    {
        $logger  = $GLOBALS['logger'];
        $app     = $GLOBALS['app'];
        $subject = $app->getSubject();
        $logger->debug('Subject authentication status = '.$subject->isAuthenticated());
        if ($subject === null) {
            $subject = Subject::createBuilder()->build();
            $app->setSubject($subject);
        }

        return $subject;

    }//end getSubject()


}//end class

?>
