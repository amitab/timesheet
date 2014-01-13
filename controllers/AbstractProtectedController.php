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
 * @author    Support Native5 <support@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */

use Native5\Control\ProtectedController;

/**
 * ProtectedController 
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
abstract class AbstractProtectedController extends ProtectedController
{


    /**
     * _handleUnauthorizedAccess 
     * 
     * @access protected
     * @return void
     */
    protected function _handleUnauthorizedAccess()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
                $response = array();
                $response['redirect'] = "./";
                echo json_encode($response);
                exit;
        } else {
                header("Location: ./");
                exit;
        }
    }


    /**
     * _handleUnauthenticatedAccess 
     * 
     * @access protected
     * @return void
     */
    protected function _handleUnauthenticatedAccess()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
                $response = array();
                $response['redirect'] = "./";
                echo json_encode($response);
                exit;
        } else {
                header("Location: ./");
                exit;
        }
    }
}
?>
