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
 * AuthRealm
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
abstract class AuthRealm implements Realm
{

    // TODO : Implement Caching
    private $_name;


    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->setName('Authenticating Realm');

    }//end __construct()


    /**
     * setName 
     * 
     * @param mixed $name Name of realm
     *
     * @access public
     * @return void
     */
    public function setName($name)
    {
        $this->_name = $name;

    }//end setName()


    public function getName()
    {
        return $this->_name;

    }//end getName()


    /**
     * supportsToken 
     * 
     * @param mixed $token The token which needs to be supported
     *
     * @access public
     * @return void
     */
    public function supportsToken($token)
    {
        return $token != null && $token->getClass() instanceof UserPwdToken;

    }//end supportsToken()


    /**
     * getAuthenticationInfo 
     * 
     * @param mixed $token The token which needs to be authenticated.
     *
     * @final
     * @access public
     * @return void
     */
    final public function getAuthenticationInfo($token)
    {
        // TODO: Retrieve Authentication Info from Cache
        $authInfo = $this->doGetAuthenticationInfo($token);
        if ($authInfo) {
            $this->_matchCredentials($token, $authInfo);
        }

        return $authInfo;

    }//end getAuthenticationInfo()


    // Actual function which handles retrieval of Authentication Info
    abstract protected function doGetAuthenticationInfo($token);


    /**
     * _matchCredentials 
     * 
     * @param mixed $token    The token to match 
     * @param mixed $authInfo The authentication info to match the token with
     *
     * @access private
     * @return void
     * @throws Exception
     */
    private function _matchCredentials($token, $authInfo)
    {
        $tokenCred = $token->getCredentials();
        $authCred  = $authInfo->getCredentials();
        // TODO: Extract validation logic to CredentialsMatcher.
        if(PasswordUtils::check($tokenCred, $authCred) !== 'OK')
            throw new Exception('Incorrect Credentials');

    }//end _matchCredentials()


}//end class

?>
