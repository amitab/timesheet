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

namespace Native5\Route\DeviceDetection;

/**
 * Browser 
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
class Browser {
    private $_id;
    private $name;
    private $version;

    private $renderingEngine;
    private $jsEngine;
    private $device;

    private $score;
    private $attributes; //TODO:Need to think about what all attributes need to be captured

    private $isGraded;
    private $grade;

    public function __construct($name=NULL, $vers=NULL, $render=NULL, $js=NULL, $device=NULL) {
        $this->name = $name;	
        $this->renderingEngine = $render;
        $this->jsEngine = $js;
        $this->version = $vers;
        if($device != NULL)
            $this->device = $device;
        else
            $this->device = new Device();
        $this->attributes = array();
    }

    public function addAttribute($name, $val) {
        $this->attributes[$name]=$val;
    }

    public function setGrade($grade) {
        $this->grade = $grade;
    }

    public function setScore($score) {
        $this->score = $score;
    }

    public function getVersion() {
        return $this->version;
    }

    public function getDevice() {
        return $this->device;
    }

    public function getRenderEngine() {
        return $this->renderingEngine;
    }

    public function getScriptEngine() {
        return $this->jsEngine;
    }

    public function getHTML5Score() {
        return $this->score;
    }

    public function isGraded() {
        return $this->isGraded;
    }

    public function getGrade() {
        return $this->grade;
    }
}
?>
