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
 * DefaultIdentityManager 
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
class DefaultIdentityManager implements IdentityManager
{


    public function isAuthenticated() {
        global $logger;
        // TODO: Have to fix CSRF for gradeD browsers.
        $cToken = false;
        //$logger->info(' Tokens = { '.$_REQUEST['rand_token'].', '.$_SESSION['cToken'].'}');
        if(isset($_REQUEST['rand_token'])) {
            $randToken = $_REQUEST['rand_token'];
            if(isset($_SESSION['cToken']) && $randToken == $_SESSION['cToken']) 
                $cToken = true;
        }
        if(isset($_SESSION['category']) && $_SESSION['category'] == 'D')
            $cToken = true;
        if(isset($_SESSION['ID']) && $cToken==TRUE) return true;
        return false;
    }

    public function isAuthorized() {
        if(isset($_SESSION['ID'])) return true;
        return false;
    }

    public function authenticate($user) {
        $token = "#544719020012012";
        return $token;
    }

    public function authorize($userToken) {
        $authToken = "#544719020012012";
        return $authToken;
    }
}
?>
