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
class Command {
    private $_name;
    private $_function;
    private $_params;

    public function __construct($controllerName,$functionName, $parameters) {
        $this->_name = $controllerName;
        $this->_params = $parameters;
        $this->_function = $functionName;
    }

    function getControllerName() {
        return $this->_name;
    }

    function setControllerName($controllerName) {
        $this->_name = $controllerName;
    }

    function getFunction() {
        return $this->_function;
    }

    function setFunction($name) {
        $this->_function = $name;
    }

    function getParameters() {
        return $this->_params;
    }

    function setParameters($params) {
        $this->_params = $params;
    }
}
?>
