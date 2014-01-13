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
class RoutingEngine
{


    /**
     * route Handles incoming requests. 
     * 
     * @access public
     * @return void
     */
    public function route()
    {
        global $logger;
        try {
            // TODO : Refactor Code :
            // $url    = URLParser::parse();
            // $route  = RouteMapper::getRoute($url['route']);
            // $router = new Router();
            // $router->route($route);
            $urlInterpreter = new UrlInterpreter();
            $command        = $urlInterpreter->getCommand();
            $router         = new Router($command);
            $logger->debug('Routing to : '.$command->getControllerName());
            $router->route();
        } catch (Exception $e) {
            throw new RouteNotFoundException();	
        }
    }
}
?>
