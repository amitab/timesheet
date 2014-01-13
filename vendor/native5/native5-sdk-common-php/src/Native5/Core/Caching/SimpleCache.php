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
 * @category  Caching 
 * @package   Native5\Core\Caching
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */

namespace Native5\Core\Caching;

/**
 * SimpleCache 
 *
 * @category  Cache
 * @package   Native5\Core\Caching
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0
 * @link      http://www.docs.native5.com
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class SimpleCache implements ICache {
    private static $_instance;
    private $_cache;

    public static function instance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new self();	
        }
        return self::$_instance;
    }

    private function __construct() {
        $this->_cache = array();
    }

    public function get($key) {
        if(array_key_exists($key, $this->_cache))
            return $this->_cache[$key];
        return null;
    }

    public function set($key, $object) {
        $this->_cache[$key] = $object;
    }

    public function exists($key) {
        return isset($this->_cache[$key]) && !is_null($this->_cache[$key]);
    }

    public function delete($key) {
        unset($this->_cache[$key]);
    }

    public function flush() {
        $this->_cache = array();
    }
}
?>
