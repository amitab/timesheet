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
 * @category  Control 
 * @package   Native5\Control
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Route;

/**
 * HttpRequest 
 * 
 * @category  Control 
 * @package   Native5\Control
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class HttpRequest implements Request
{

    private $_rawRequest;

    private $_keys;
    
    private $_params;


    /**
     * __construct 
     * 
     * @param mixed $mandatoryKeys Mandatory Keys
     *
     * @access public
     * @return void
     */
    public function __construct($keys=null)
    {
        $this->_rawRequest = $_REQUEST;
        if(empty($keys) === true)
            $this->_keys = array();
        else
            $this->_keys = $keys;
        $this->_params = array();

    }//end __construct()


    /**
     * getParam 
     * 
     * @param mixed $key Param to retrieve based on key
     *
     * @access public
     * @return void
     */
    public function getParam($key)
    {
        if(isset($this->_rawRequest[$key]))
            return $this->_rawRequest[$key];
        return null;

    }//end getParam()


    /**
     * getParams 
     * 
     * @access public
     * @return void
     */
    public function getParams()
    {
        return $this->_params;

    }//end getParams()


    /**
     * setKeys
     * 
     * @param mixed $keys Mandatory Keys or not. 
     *
     * @access public
     * @return void
     */
    public function setKeys($keys)
    {
        $this->_keys = $keys;

    }//end setKeys()


    /**
     * parse 
     * 
     * @access public
     * @return void
     * @throws MissingParamsException
     */
    public function parse()
    {
        foreach ($this->_keys as $key) {
            if(empty($this->_rawRequest[$key['name']]) === true && $key['type'] === 'mandatory')
                throw new MissingParamsException();
        }

    }//end parse()


}//end class

?>
