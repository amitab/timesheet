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
class ProfileController extends \My\Control\ProtectedController
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
        $skeleton =  new TwigRenderer('profile-test.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        $userId = $this->user->getUserId(); // Get current user Id
        $userService = \Timesheet\User\Service::getInstance();
        $stats = $userService->getUserStats($userId);
        
        $notificationService = \Timesheet\Notification\Service::getInstance();
        $notifications = $notificationService->getUnreadNotificationCountForUser($this->user->getUserId());
        
        $this->_response->setBody(array(
            'title' => 'Profile',
            'image_path' => IMAGE_PATH,
            'user' => $this->user,
            'stats' => $stats,
            // The sidebar and header data
            'email' => $this->user->getUserMail(),
            'name' => $this->user->getUserFirstName() . ' ' . $this->user->getUserLastName(),
            'image' => IMAGE_PATH . $this->user->getUserImageUrl(),
            'unread_notification' => $notifications
            
        )); 


    }//end _default()
    
    public function _view($request) {
        global $logger;
        $skeleton =  new TwigRenderer('profile-test.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        $userId = (int) $request->getParam('id');
        $userService = \Timesheet\User\Service::getInstance();
        $user = $userService->getUserById($userId);
        $user = $user[0];
        $stats = $userService->getUserStats($userId);
        
        $notificationService = \Timesheet\Notification\Service::getInstance();
        $notifications = $notificationService->getUnreadNotificationCountForUser($this->user->getUserId());
        
        $this->_response->setBody(array(
            'title' => 'Profile',
            'image_path' => IMAGE_PATH,
            'user' => $user,
            'stats' => $stats,
            'view_profile' => true,
            // The sidebar and header data
            'email' => $this->user->getUserMail(),
            'name' => $this->user->getUserFirstName() . ' ' . $this->user->getUserLastName(),
            'image' => IMAGE_PATH . $this->user->getUserImageUrl(),
            'unread_notification' => $notifications
        )); 
    }
    
    public function _edit_profile($request)
    {
        
        global $logger;
        $skeleton =  new TwigRenderer('editprofile.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        if($request->getParam('edit') != null) {
            
            $upload = $this->_save_image();
            if(!$upload) {
                $message['fail'] = 'Could not update profile picture.';
            } 
            
            $user = $this->user;
            $user->setUserFirstName($request->getParam('first_name'));
            $user->setUserLastName($request->getParam('last_name'));
            $user->setUserPhoneNumber($request->getParam('phone_number'));
            $user->setUserLocation($request->getParam('location'));
            
            $userService = \Timesheet\User\Service::getInstance();
            if($userService->editUser($user)) {
                $message['success'] = 'Updated successfuly.';
            } else {
                $message['fail'] = 'Could not update.';
            }
            
        }
        
        $user = $this->user;
        
        $this->_response->setBody(array(
            'title' => 'Edit Profile',
            'user' => $user,
            'message' => $message,
            // The sidebar and header data
            'email' => $this->user->getUserMail(),
            'name' => $this->user->getUserFirstName() . ' ' . $this->user->getUserLastName(),
            'image' => IMAGE_PATH . $this->user->getUserImageUrl()
        )); 

    }
    
    private function _save_image() {
        $userId = $this->user->getUserId(); // Get current user Id
        $userService = \Timesheet\User\Service::getInstance();
        $userImagePath = $userService->getUserImageUrl($userId);
        
        if(isset($_FILES['user_image'])) {
                
            try {
                $uploader = new \Database\Upload();
                $uploader->uploadPath = UPLOAD_PATH;
                $uploader->arrayName = 'user_image';
                $uploader->maxFileSize = 10000000;
                
                // For Resizing
                $uploader->thumbUploadPath = THUMB_UPLOAD_PATH;
                $uploader->crop = true;
                $uploader->width = 100;
                $uploader->height = 100;
                
                $newFileName = $uploader->upload();
                
                $image_path = IMAGE_PATH . $newFileName;
                
                // Update database with new pic name. Delete this pic if database update fails.
                if($userService->uploadUserImage($newFileName, $userId)) {
                    $successful[] = 'Image has been updated.';
                    $this->user->setUserImageUrl($newFileName);
                    return $newFileName;
                } else {
                    $warnings[] = 'Image could not be updated.';
                    unlink($uploader->uploadPath . $newFileName);
                    return false;
                }
                
            } catch (\Exception $e) {
                return false;
            }
            
        } else {
            return false;
        }
    }
    
    public function _upload_image($request) {
        global $logger;
        $warnings = array();
        $successful = array();
        
        $skeleton =  new TwigRenderer('uploadprofileimage.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        $userId = $this->user->getUserId(); // Get current user Id
        $userService = \Timesheet\User\Service::getInstance();
        $userImagePath = $userService->getUserImageUrl($userId);
        
        if(isset($_FILES['user_image'])) {
                
            try {
                $uploader = new \Database\Upload();
                $uploader->uploadPath = UPLOAD_PATH;
                $uploader->arrayName = 'user_image';
                $uploader->maxFileSize = 10000000;
                
                // For Resizing
                $uploader->thumbUploadPath = THUMB_UPLOAD_PATH;
                $uploader->crop = true;
                $uploader->width = 100;
                $uploader->height = 100;
                
                $newFileName = $uploader->upload();
                
                $image_path = IMAGE_PATH . $newFileName;
                
                // Update database with new pic name. Delete this pic if database update fails.
                if($userService->uploadUserImage($newFileName, $userId)) {
                    $successful[] = 'Image has been updated.';
                } else {
                    $warnings[] = 'Image could not be updated.';
                    unlink($uploader->uploadPath . $newFileName);
                }
                
            } catch (\Exception $e) {
                $warnings[] = $e->getMessage();
                $image_path = IMAGE_PATH . $userImagePath; // Show default pic
            }
        } else {
            $image_path = IMAGE_PATH . $userImagePath; // Show default pic
        }
        
        $notificationService = \Timesheet\Notification\Service::getInstance();
        $notifications = $notificationService->getUnreadNotificationCountForUser($this->user->getUserId());
        
        $this->_response->setBody(array(
            'title' => 'Upload Image',
            'image_path' => $image_path,
            'warnings' => $warnings,
            'successful' => $successful,
            // The sidebar and header data
            'email' => $this->user->getUserMail(),
            'name' => $this->user->getUserFirstName() . ' ' . $this->user->getUserLastName(),
            'image' => IMAGE_PATH . $this->user->getUserImageUrl(),
            'unread_notification' => $notifications
        )); 
    }
    
    public function _change_password($request) {
        global $logger;
        
        $skeleton =  new TwigRenderer('change-password.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        $notificationService = \Timesheet\Notification\Service::getInstance();
        $notifications = $notificationService->getUnreadNotificationCountForUser($this->user->getUserId());
        
        if($request->getParam('edit') != null) {
            
        }
        
        $this->_response->setBody(array(
            'title' => 'Change Password',
            // The sidebar and header data
            'email' => $this->user->getUserMail(),
            'name' => $this->user->getUserFirstName() . ' ' . $this->user->getUserLastName(),
            'image' => IMAGE_PATH . $this->user->getUserImageUrl(),
            'unread_notification' => $notifications
        ));
    }

}//end class

?>
