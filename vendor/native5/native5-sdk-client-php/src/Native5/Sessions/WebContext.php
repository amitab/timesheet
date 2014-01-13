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
 * @category  Sessions
 * @package   Native5\Sessions
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Sessions;

use Native5\Route\DeviceDetection\DeviceManager;

/**
 * Web context for the current app. 
 * 
 * @category  Sessions
 * @package   Native5\Sessions
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class WebContext
{

    private $_map;


    /**
     * Default constructor 
     * 
     * @param mixed $request User Request object.
     *
     * @access public
     * @return void
     */
    public function __construct($request=null)
    {
        $app = $GLOBALS['app'];
        if ($request === null) {
            $request = $_REQUEST;
        }

        $this->_map             = array();
        $deviceMgr              = new DeviceManager();
        $this->_map['device']   = $deviceMgr->determineCategory(
            $_SERVER["HTTP_USER_AGENT"], 
            $app->getConfiguration()->getDefaultGrade()
        );
        $latitude               = isset($_REQUEST['lat']) ? $_REQUEST['lat'] : '0.00';
        $longitude              = isset($_REQUEST['lng']) ? $_REQUEST['lng'] : '0.00';
        $this->_map['location'] = array('latitude' => $latitude, 'longitude' => $longitude);

    }//end __construct()


    /**
     * Get attribute from web context. 
     * 
     * @param mixed $key The key to search for in the map.
     *
     * @access public
     * @return void
     */
    public function get($key)
    {
        if (array_key_exists($key, $this->_map)) {
            return $this->_map[$key];
        }

        return null;

    }//end get()


}//end class

?>
