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
 * @category  Route 
 * @package   Native5\Route
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Route;

/**
 * RoutingEngine 
 * 
 * @category  Route 
 * @package   Native5\Route
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class Router
{

    private $_command;


    /**
     * Router 
     * 
     * @param mixed $command The command to use to route.
     *
     * @access public
     * @return void
     */
    public function __construct($command)
    {
        $this->_command = $command;

    }//end __construct()


    /**
     * routeExists 
     * 
     * @param mixed $controllerName Controller Name if it exists
     *
     * @access public
     * @return void
     */
    public function routeExists($controllerName)
    {
        return file_exists('controllers/'.$controllerName.'.php');

    }//end routeExists()


    /**
     * route 
     * 
     * @access public
     * @return void
     */
    public function route()
    {
        global $logger;
        $controllerName = $this->_command->getControllerName();
        
        if (!$this->routeExists($controllerName)) {
            $controllerName = 'error';
        }

        include 'controllers/'.$controllerName.'.php';
        
        $controllerClass = $controllerName.'Controller';
        $controller = new $controllerClass($this->_command);
        try {
            $params = $controller->getParams();
            $request = new HttpRequest($params);
            $request->parse();
            $controller->execute($request);
        } catch(MissingParamsException $mpe) {
            $response = new HttpResponse();
            $response->addHeader('HTTP/1.1 400 Bad Request');
            $response->send();
        } catch(ServiceException $sxe) {
            $response = new HttpResponse();
            $response->sendError($sxe->getMessage());
        } catch(ClientException $cxe) {
            $response = new HttpResponse();
            $response->sendError($cxe->getMessage(), $cxe->getCode());
        }
    }//end route()

}//end class

?>
