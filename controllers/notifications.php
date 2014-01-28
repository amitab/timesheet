<?php
/**
 * Copyright © 2013 Native5
 * 
 * All Rights Reserved.  
 * Licensed under the Native5 License, Version 1.0 (the "License"); 
 * You may not use this file except in compliance with the License. 
 * You may obtain a copy of the License at
 *  
 *      http://www.native5.com/legal/npl-v1.html
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *  PHP version 5.3+
 *
 * @category  Controllers 
 * @package   App/Controllers
 * @author    Support Native5 <support@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

use Native5\Control\DefaultController;
use Native5\Route\HttpResponse;
use Native5\UI\TwigRenderer;
use Native5\Identity\UsernamePasswordToken;
use Native5\Identity\AuthenticationException;
use Native5\Identity\SecurityUtils;

/**
 * Home Controller
 *
 * @category  Controllers 
 * @package   App/Controllers
 * @author    Support Native5 <support@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0
 * @link      http://www.docs.native5.com
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class NotificationsController extends \My\Control\ProtectedController
{


    /**
     * _default 
     * 
     * @param mixed $request Request to use
     *
     * @access public
     * @return void
     */    
    public function _default($request)
    {
        
        global $logger;
        $skeleton =  new TwigRenderer('notifications.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        
        $this->_response->setBody(array(
            'title' => 'Notifications',
            'refresh' => true
        )); 
    }
    
    public function _search($request) {
        
        global $logger;
        
        $userId = 5;
        $notificationService = \Timesheet\Notification\Service::getInstance();
        
        $this->_response = new HttpResponse('json');
        if($request->getParam('offset') != null) {
            $offset = (int) $request->getParam('offset');
            $data = $notificationService->getNotificationsToUser($userId, $offset);
            $data = \Database\Converter::getArray($data);
        } else {
            $data = $notificationService->getNotificationsToUser($userId);
            $data = \Database\Converter::getArray($data);
        }
        
        if(empty($data)) {
            $lol = 'You got no more messages brah.';
        }
        
        $this->_response->setBody(array(
            'notifications' => $data,
            'lol' => $lol
        ));      
    }

}//end class

?>
