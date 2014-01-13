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
 * @category  Controllers 
 * @package   Native5\Control
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */
namespace Native5\Control;

use Native5\Sessions\WebSessionManager;
use Native5\Security\DefaultIdentityManager;
use Native5\Security\WebSecurityManager;
use Native5\UI\TwigRenderer;

/**
 * ProtectedController
 *
 * @category  Controllers
 * @package   Native5\Control
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0
 * @link      http://www.docs.native5.com
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
abstract class ProtectedController extends DefaultController
{


    /**
     * Default Constructor. 
     * 
     * @param mixed &$command Command to execute.
     *
     * @access public
     * @return void
     */
    public function __construct(&$command)
    {
        parent::__construct($command);
        $this->addPreProcessor(new WebSecurityManager());

    }//end __construct()


    /**
     * Checks for secure routing,
     * currently security is handled at a base route level,
     * 
     * @param mixed $request Execute request.
     *
     * @access public
     * @return void
     */
    public function execute($request)
    {
        $logger = $GLOBALS['logger'];

        try {
            parent::execute($request);
        } catch(AuthenticationException $ex) {
            $logger->error('Unauthorized attempt to access resource, being redirected to home page', array($ex->getMessage()));
            $this->_handleUnauthenticatedAccess();
        }
    }


    /**
     * Handle Unauthorized access. 
     * 
     * @access protected
     * @return void
     */
    protected function _handleUnauthorizedAccess()
    {
        header("HTTP/1.0 401 Unauthorized");
        exit;

    }//end _handleUnauthorizedAccess()


    /**
     * Handle Unauthenticated access. 
     * 
     * @access protected
     * @return void
     */
    protected function _handleUnauthenticatedAccess()
    {
        header("HTTP/1.0 401 Unauthorized");
        $renderer = new TwigRenderer();
        $output = $renderer->render('unauth.tmpl', array());
        $result = array("code"=>"401","message" => $output);
        echo parent::encodeData($result);
        exit;

    }//end _handleUnauthenticatedAccess()


}//end class
