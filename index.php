<?php
/**
 *  Copyright 2012 Native5. All Rights Reserved
 *
 *  Licensed under Native5 License, Version 1.0 (the "License");
 *  You may not use this file except in compliance with the License.
 *
 *  You may obtain a copy of the License at
 *  http://www.native5.com/licenses/LICENSE-1.0
 *  or in the "license" file accompanying this file.
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *  PHP version 5.3+
 *
 * @category  Sample_Application
 * @package   None 
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */

require 'vendor/autoload.php';

use Native5\Application;
use Native5\Route\HttpRequest;

$app = Application::init();
$app->route(new HttpRequest());

?>
