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
 * @category  Sessions
 * @package   Native5\Sessions
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */
namespace Native5\Sessions;

use Native5\Core\Database\DB;
use Native5\Core\Caching\MemcacheCache;
use Native5\Core\Caching\SimpleCache;

/**
 * CachedSessionHandler
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
class CachedSessionHandler
{

    private $_db;

    private $_cache;

    private $_sessionExpiryInterval;


    /**
     * __construct Default Constructor.
     * 
     * @param int $expiryInterval (defaults to 300s)
     *
     * @access public
     * @return void
     */
    public function __construct($expiryInterval=300)
    {
        $this->_db = DB::instance();
        $this->_cache = SimpleCache::instance();
        $this->_sessionExpiryInterval = $expiryInterval;

    }//end __construct()


    /**
     * destroy Destroying the session deletes it from the cache as 
     * well as the backend database. 
     * 
     * @param mixed $sessionId The session id
     *
     * @access public
     * @return void
     */
    public function destroy($sessionId)
    {
        $sql    = 'DELETE from tbl_sessions where SESSION_ID=:SESSID';
        $delete = $this->_db->prepare($sql);
        $delete->execute(array(':SESSID' => $sessionId));
        $this->_cache->delete($sessionId);

        return true;

    }//end destroy()


    /**
     * Garbage collection causes all expired sessions to be deleted. 
     * 
     * @param mixed $lifetime The max-lifetime of the session.
     *
     * @access public
     * @return void
     */
    public function gc($lifetime)
    {
        $sql    = 'DELETE from tbl_sessions where LAST_ACCESSED < DATE_SUB(NOW(), INTERVAL :LIFETIME SECOND)';
        $delete = $this->_db->prepare($sql);
        $count  = $delete->execute(array(':LIFETIME' => $lifetime));

        return true;

    }//end gc()


    /**
     * open Opening the session causes an insert into the sessions table. 
     * 
     * @param mixed $savePath    SavePath, relevant only while persisting to disk.
     * @param mixed $sessionName SessionName
     *
     * @access public
     * @return void
     */
    public function open($savePath, $sessionName)
    {
        $sql  = 'INSERT INTO tbl_sessions (SESSION_ID, SESSION_DATA) values (:SESSID, :SESSDATA) ON DUPLICATE KEY UPDATE LAST_ACCESSED=NOW()';
        $stmt = $this->_db->prepare($sql);
        $stmt->execute(array(':SESSID' => session_id(), ':SESSDATA' => ''));

    }//end open()


    /**
     * close Closes the session object. 
     * 
     * @access public
     * @return void
     */
    public function close()
    {
        $sessionId = session_id();

    }//end close()


    /**
     * read Reading the session from the cache/db. 
     * 
     * @param mixed $sessionId The session id with which to read.
     *
     * @access public
     * @return void
     */
    public function read($sessionId)
    {
        $sessionData = $this->_cache->get($sessionId);
        if (empty($sessionData) === false) {
            $this->_cache->set($sessionId, $sessionData, array('expiry' => $this->_sessionExpiryInterval));

            return $sessionData;
        }

        $sql    = 'SELECT SESSION_DATA FROM tbl_sessions where SESSION_ID=:SESSID';
        $select = $this->_db->prepare($sql);
        $select->execute(array(':SESSID' => $sessionId));
        $result = $select->fetchColumn();
        if (empty($result) === false) {
            $this->_cache->set($sessionId, $result, array('expiry' => $this->_sessionExpiryInterval));

            return $result;
        }

        return '';

    }//end read()


    /**
     * Updates &/or inserts session data. 
     * 
     * @param mixed $sessid   Session ID
     * @param mixed $sessdata The session data
     *
     * @access public
     * @return void
     */
    public function write($sessid, $sessdata)
    {
        $this->_cache->set(
            $sessid,
            $sessdata,
            array('expiry' => $this->_sessionExpiryInterval)
        );
        $sql  = 'INSERT INTO tbl_sessions (SESSION_ID, SESSION_DATA) 
            values (:SESSID, :SESSDATA) ON DUPLICATE KEY 
            UPDATE SESSION_DATA=:SDATA, LAST_ACCESSED=NOW()';
        $stmt = $this->_db->prepare($sql);
        $stmt->execute(
            array(
             ':SESSID'   => $sessid,
             ':SESSDATA' => $sessdata,
             ':SDATA'    => $sessdata,
            )
        );

        return true;

    }//end write()


}//end class

?>
