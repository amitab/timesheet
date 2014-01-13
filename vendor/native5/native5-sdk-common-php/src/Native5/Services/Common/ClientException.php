<?php
/**
 * Copyright © 2013 Native5
 * 
 * All Rights Reserved.  
 * Licensed under the Native5 License, Version 1.0 (the "License"); 
 * You may not use this file except in compliance with the License. 
 * You may obtain a copy of the License at
 *  
 *      http://www.native5.com/legal/npl-v1.html
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *  PHP version 5.3+
 */

namespace Native5\Services\Common;

use \Exception as Exception;

/**
 * ClientException 
 * 
 * @category  Services 
 * @package   Native5\Services\Common
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created :  25-Oct-2013 
 * Last Modified : Fri Oct 25 11:57:38 2013
 */
class ClientException extends Exception 
{

    /**
     * Default Constructor 
     * 
     * @param mixed     $message The message 
     * @param int       $code    The exception code.
     * @param Exception $prev    The previous exception.
     *
     * @access public
     * @return void
     */
    public function __construct($message, $code=400, Exception $prev = null)
    {
         parent::__construct($message, $code, $prev);
    }


    /**
     * __toString 
     * 
     * @access public
     * @return void
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    
}

