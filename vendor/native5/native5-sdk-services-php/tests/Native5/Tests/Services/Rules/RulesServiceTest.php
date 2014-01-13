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
namespace Native5\Tests\Services\Rules;

use Native5\Services\Rules\RemoteRulesService;

class RulesServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Service
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new RemoteRulesService();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        unset($this->object);
    }

    /**
     * @covers Native5\Services\Rules\RemoteRulesService->evaluateRules()
     * 
     */
    public function testEvaluateRules()
    {

        $order = array();
        $order['entries'] = array();
        $order['entries'][] = array('sku'=>'IAD', 'skuQty'=>20);
        $order['entries'][] = array('sku'=>'Magik', 'skuQty'=>20);
        $order['entries'][] = array('sku'=>'IAD', 'skuQty'=>60, 'runScheme'=>true);
        $ruleOutcome = json_decode($this->object->evaluateRules($order),1);

        $this->assertNotNull(
            $ruleOutcome['sku'],
            'Rule Evaluation Not Null'
        );
    }
}

