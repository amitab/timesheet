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
        
        $userId = 1;
        $userService = \Timesheet\User\Service::getInstance();
        $user = $userService->getUserById($userId);
        $user = $user[0];
        $stats = $userService->getUserStats($userId);
        
        $this->_response->setBody(array(
            'title' => 'Profile',
            'image_path' => IMAGE_PATH,
            'user' => $user,
            'stats' => $stats
        )); 


    }//end _default()
    
    public function _edit_profile($request)
    {
        
        global $logger;
        $skeleton =  new TwigRenderer('editprofile.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        
        $userId = 1;
        $userService = \Timesheet\User\Service::getInstance();
        $user = $userService->getUserById($userId);
        $user = $user[0];
        
        $this->_response->setBody(array(
            'title' => 'Edit Profile',
            'inline_menu' => true,
            'form_save' => true,
            'user' => $user
        )); 

    }
    
    public function _upload_image($request) {
        global $logger;
        $warnings = array();
        $successful = array();
        
        $skeleton =  new TwigRenderer('uploadprofileimage.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        $userId = 1;
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
                // unlink($uploader->uploadPath . $newFileName);
                
                $successful[] = 'Image has been updated';
                
            } catch (\Exception $e) {
                $warnings[] = $e->getMessage();
                $image_path = IMAGE_PATH . $userImagePath; // Show default pic
            }
        } else {
            $image_path = IMAGE_PATH . $userImagePath; // Show default pic
        }
        
        $this->_response->setBody(array(
            'title' => 'Upload Image',
            'image_path' => $image_path,
            'warnings' => $warnings,
            'successful' => $successful,
        )); 
    }
    
    public function _change_password($request) {
        global $logger;
        
        $skeleton =  new TwigRenderer('change-password.html');
        $this->_response = new HttpResponse('none', $skeleton);
        
        $this->_response->setBody(array(
            'title' => 'Change Password',
        ));
    }

}//end class

?>
