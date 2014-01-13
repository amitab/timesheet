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
 *
 * @category  <category> 
 * @package   Native5\Core\<package>
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Services\Rules;

use Native5\Services\Common\ApiClient;

/**
 * SchemeRemoteDAO 
 * 
 * @category  Schemes 
 * @package   Akzo\Schemes
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class RemoteRulesService extends ApiClient
{



    /**
     * Find the rules by pattern 
     * 
     * @param mixed $rulePattern 
     * @access public
     * @return void
     */
    public function findByPattern($rulePattern) {
        $logger = $GLOBALS['logger'];
        $path    = 'rules/';
        $request = $this->_remoteServer->get($path);
        $query = $request->getQuery();
        $query->set('pattern',$rulePattern);
        $logger->info(print_r($query,1));
        //$request = $this->_remoteServer->get($path, array(), array('pattern'=>urlencode($rulePattern))); 
        try {
            $response = $request->send();
            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Unable to handle request');
            }
            $rawResponse = $response->getBody('true');
            return $rawResponse;
        } catch (\Exception $e) {
            throw $e; 
        }
        
    }//end findByPattern()


    /**
     * Save Rule in Database 
     * 
     * @param mixed $rule
     *
     * @access public
     * @return void
     */
    public function saveRule($rule) {
        $logger = $GLOBALS['logger'];
        $path    = 'rules/create';
        $request = $this->_remoteServer->post(
            $path,
            array('Content-Type'=>'application/json'),
            $rule
        );
        try {
            $response = $request->send();
            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Unable to handle request');
            }
            $rawResponse = $response->getBody('true');
            return $rawResponse;
        } catch (\Exception $e) {
            throw $e; 
        }
        
    }//end saveRule()


    /**
     * Update Rule in Database 
     * 
     * @param mixed $rule
     *
     * @access public
     * @return void
     */
    public function updateRule($rule) {
        $logger = $GLOBALS['logger'];
        $path    = 'rules/update';
        $request = $this->_remoteServer->put(
            $path,
            array('Content-Type'=>'application/json'),
            $rule
        );
        try {
            $response = $request->send();
            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Unable to handle request');
            }
            $rawResponse = $response->getBody('true');
            return $rawResponse;
        } catch (\Exception $e) {
            throw $e; 
        }
        
    }//end saveRule()


    /**
     * Evaluate incoming data against available rules. 
     * 
     * @param mixed $data 
     *
     * @access public
     * @return void
     */
    public function evaluateRules($ruleData)
    {
        $logger = $GLOBALS['logger'];
        $path    = 'rules/execute';
        $request = $this->_remoteServer->post(
            $path,
            array('Content-Type'=>'application/json'),
            $ruleData
        );
        try {
            $response = $request->send();
            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Unable to handle request');
            }
            $rawResponse = $response->getBody('true');
            $logger->debug('Rule Evaluation Outcome = '.print_r($rawResponse,1));
            return $rawResponse;
        } catch (\Exception $e) {
            throw $e; 
        }
    }
}
?>
