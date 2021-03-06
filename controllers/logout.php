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
 * @category  Routing
 * @package   Native5\Core\Route
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */

use Native5\Control\DefaultController;
use Native5\Sessions\WebSessionManager;
use Native5\Route\HttpResponse;

/**
 * LogoutHandler
 *
 * @category  Routing
 * @package   Native5\Core\Route
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0
 * @link      http://www.docs.native5.com
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class LogoutController extends DefaultController
{


    /**
     * _default 
     * 
     * @param mixed $request Request to process.
     *
     * @access public
     * @return void
     */
    public function _default($request)
    {
        WebSessionManager::resetActiveSession();
        $headers = apache_request_headers();
        if (isset($headers["X-Requested-Native5-App"])){
            $this->_response = new HttpResponse('json');
            $this->_response->setBody(array(
                'success' => true
            ));
        } else {
            $this->_response->redirectTo('home');
        }
        //header('Location: ./');
    }//end _default()


}//end class

?>
