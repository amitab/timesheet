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
 * @category  Identity
 * @package   Native5\Identity
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Identity;

/**
 * DBRealm
 * 
 * @category  Identity 
 * @package   Native5\Identity
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class DBRealm extends AuthRealm
{

    private $_db;


    /**
     * Default Constructor. 
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent();
        $this->setName('DB Realm');
        $this->_db = DB::instance();

    }//end __construct()


    /**
     * doGetAuthenticationInfo 
     * 
     * @param mixed $token Token to use for authentication 
     *
     * @access protected
     * @return void
     */
    protected function doGetAuthenticationInfo($token)
    {
        if(!token instanceof UsernamePasswordToken)
            throw new Exception('Invalid Token Type');
        $user = $token->getPrincipal();
        if(!$user)
            throw new Exception('Null usernames not permitted');
        $password = $this->_getPasswordFromDB($user);
        $account = new DefaultAccount($user, $password);
        return $account;
    
    }//end doGetAuthenticationInfo()


    /**
     * _getPasswordFromDB 
     * 
     * @param mixed $user The user to fetch the password for
     *
     * @access public
     * @return void
     */
    public function _getPasswordFromDB($user)
    {
        $sql  = 'SELECT * FROM users WHERE code = :uname AND state >=1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(':uname' => $token->getUserName()));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['password'];

    }//end _getPasswordFromDB()


}//end class

?>
