<?php
/**
 * Copyright © 2013 Native5. All Rights Reserved.  
 *
 * Licensed under the Native5 License, Version 1.0 (the "License"); 
 * You may not use this file except in compliance with the License. 
 * You may obtain a copy of the License at
 *  
 *      http://www.native5.com/legal/license/v10
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * @category  Security 
 * @package   Akzo\Control\Security\<package>
 * @author    Shamik Datta <shamik@native5.com>
 * @copyright 2013 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace My\Control\Security;

/**
 * AuthPreprocessor 
 */
class AuthPreprocessor implements \Native5\Control\PreProcessor
{
    /**
     * process Authenticated Pre-Processor 
     * 
     * @param mixed $request The request to pre-process.
     *
     * @access public
     * @return void
     */
    public function process(&$request)
    {
        if (!(\Native5\Identity\SecurityUtils::getSubject()->isAuthenticated()))
           throw new \Native5\Control\AuthenticationException;
    }
}
