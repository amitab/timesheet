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
 * @category  Security 
 * @package   Native5\Security
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */
namespace Native5\Security;

/**
 * LDAPIdentityManager 
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
class LDAPIdentityManager implements IdentityManager {
	
	public function isAuthenticated() {
		return false;
	}
	
	public function isAuthorized() {
		return true;
	}

	/**
	 * Authenticate using request &/or credentials in request.
	 * Authentication results in authentication token being generated. 
	 *
	 */
	public function authenticate($user) {
		$token = "#544719020012012";
		return $token;
	}

	/**
	 * Authorization of user based on userToken. 
	 * Generates token which will provide user access levels to functions.
	 *
	 */ 
	public function authorize($userToken) {
		$authToken = ''; // Token which can be used to define user access.
		return $authToken;
	}
}
?>
