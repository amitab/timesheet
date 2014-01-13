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
class UrlInterpreter {
    
    private $command;

    public function __construct() {
        global $logger;
        $logger->info($_SERVER['REQUEST_URI']);
        $requestURI = explode('/', $_SERVER['REQUEST_URI']);
        $scriptName = explode('/',$_SERVER['SCRIPT_NAME']);

        $commandArray = array_diff_assoc($requestURI,$scriptName);
        $commandArray = array_values($commandArray);

        if($_SERVER['REQUEST_METHOD']=='GET' && $_SERVER['QUERY_STRING'] != null) {
            $controlPath = explode('?',$commandArray[0]);
            $controllerName = $controlPath[0];
        } else { 
            $controllerName = $commandArray[0];
        }
        $controllerName = preg_replace( '/[-_](.?)/e',"strtoupper('$1')", $controllerName );
        if($controllerName == '') {
            $controllerName = 'home';
        }

        $controllerFunction = null;
        if(sizeof($commandArray) >1) {
            $opPaths = explode('?',$commandArray[1]);
            $controllerFunction = $opPaths[0];
        }
        $parameters = array_slice($commandArray,2);
        $this->command = new Command($controllerName, $controllerFunction, $parameters);
        
    }

    function getCommand() {
        return $this->command;
    }
}
?>
