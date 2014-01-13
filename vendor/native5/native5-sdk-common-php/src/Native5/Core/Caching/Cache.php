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
 * Cache 
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
class Cache {
    protected $_cacheImpl;

    public function __construct($cache=null) {
        if(is_null($cache)) 
            $cache=SimpleCache::instance();
        $this->_cacheImpl = $cache;
    }

    public function exists($key) {
        return $this->_cacheImpl->exists($key);
    }

    public function set($key, $object) {
        $this->_cacheImpl->set($key, $object);
    }

    public function get($key) {
        return $this->_cacheImpl->get($key);
    }

    public function delete($key) {
        if($this->_cacheImpl->exists($key)) {
            $this->_cacheImpl->delete($key);
        }
    }

    public function clear() {
        $this->_cacheImpl->flush();
    }
}
?>
