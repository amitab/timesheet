<?php
/**
 * Copyright © 2014 Native5
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
 * @package   My/Control
 * @author    Shamik <shamik@native5.com>
 * @copyright 2014 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */
namespace My\Control;

abstract class ProtectedController extends \Native5\Control\ProtectedController {
    protected $logger;
    protected $user;
    protected $request;

    /**
     * __construct Checks for authenticated access and creates user object
     * 
     * @param mixed $command 
     * @access public
     * @return void
     */
    public function __construct(&$command) {
        $this->logger = $GLOBALS['logger'];

        parent::__construct($command);
        $this->addPreProcessor(new \My\Control\Security\AuthPreprocessor);
    }

    /**
     * execute Catches exceptions while execution of the controller function
     * 
     * @param mixed $request 
     * @access public
     * @return void
     */
    public function execute($request)
    {
        $this->request = $request;
        // Set the protected user variable, before controller execution begins
        $this->_setUser();

        // Catch all order related exceptions here
        try {
            parent::execute($request);
        } catch (\Exception $_e) {
            $GLOBALS['logger']->error("Exception in class [ ".get_class($this)." ] : ".$_e->getMessage());
            $this->_response->sendError($_e->getMessage(), 400);
        }
    }

    /**
     * _handleUnauthorizedAccess 
     * 
     * @param $service Service endpoint path
     * @access protected
     * @return void
     */
    protected function _handleUnauthorizedAccess($service = 'login') {
        $this->_checkAjaxForResponse($service);
    }

    /**
     * _handleUnauthenticatedAccess 
     * 
     * @access protected
     * @return void
     */
    protected function _handleUnauthenticatedAccess($service = 'login') {
        $this->_checkAjaxForResponse($service);
    }

    // ****** Private Functions Follow ****** //

    private function _checkAjaxForResponse($service) {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->_createResponse('json');
            $this->_response->setBody(array('redirect' => $service));
        } else {
            $this->_createResponse('none');
            $this->_response->redirectTo($service);
        }
    }

    private function _createResponse($type = 'null', $template = null) {
        $this->_response = new \Native5\Route\HttpResponse($type, (!empty($template) ? new \Native5\UI\TwigRenderer($template) : null));
        $this->_response->addHeader('Cache-Control: no-cache, must-revalidate');
    }

    private function _setUser() {
        try {
            // Create the (helper) user object from the authenticated subject if present
            $subject = \Native5\Identity\SecurityUtils::getSubject();
            //$this->user = $subject;
            
            $principals = $subject->getPrincipals();
            $email = $principals[1]['email'];
            
            $userService = \Timesheet\User\Service::getInstance();
            $user = $userService->getUserByEmail($email);
            
            $this->user = $user[0];
            $this->user->setSubject($subject);
            
            // Can wrap the subject using a model object and use it instead
            //$this->user = new \My\User($subject);
        } catch (\Exception $e) {
            $this->_response->redirectTo('home');
        }
    }
}
