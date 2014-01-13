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
 * @package   Native5\<package>
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Services\Identity;

use Native5\Services\Common\ApiClient;
use Native5\Identity\Authenticator;
use Native5\Identity\Logout;
use Native5\Identity\AuthenticationException;
use Native5\Identity\SimpleAuthInfo;

/**
 * RemoteAuthenticationService
 * 
 * @category  Services\Identity 
 * @package   Native5\Services\Identity
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class RemoteAuthenticationService extends ApiClient implements Authenticator, Logout
{


    /**
     * authenticate 
     * 
     * @param mixed $token The AuthenticationToken
     *
     * @access public
     * @return <code>AuthInfo</code>
     * @throws AuthenticationException
     */
    public function authenticate($token)
    {
        $logger  = $GLOBALS['logger'];
        $path    = 'users/authenticate';
        $request = $this->_remoteServer->get($path);
        $request->getQuery()->set('username', $token->getUser()); 
        $request->getQuery()->set('password', $token->getPassword()); 
        try {
            $response = $request->send();
            if ($response->getStatusCode() !== 200) {
                throw new AuthenticationException();
            }

            $rawResponse = $response->json();

            $roles    = isset($rawResponse['roles'])?explode(',',$rawResponse['roles']):array();
            $authInfo = new SimpleAuthInfo();
            $authInfo->addPrincipal(array('displayName'=>$rawResponse['name']));
            $authInfo->addPrincipal(array('email'=>$rawResponse['email']));
            $authInfo->addPrincipal(array('account'=>$rawResponse['account']));
            
            $tokens = isset($rawResponse['token'])?$rawResponse['token']: array();
            return array($authInfo, $roles, $tokens);
        } catch (\Exception $e) {
            throw new AuthenticationException();
        }

    }//end authenticate()


    /**
     * logout 
     * 
     * @param mixed $principal Principals to logout.
     *
     * @access public
     * @return void
     */
    public function onLogout($principal)
    {
        $path    = 'users/logout';
        $request = $this->_remoteServer->get($path);
        $request->getQuery()->set('token', $principal->serialize('json'));
        $request->send();

    }//end onLogout()


}//end class

?>
