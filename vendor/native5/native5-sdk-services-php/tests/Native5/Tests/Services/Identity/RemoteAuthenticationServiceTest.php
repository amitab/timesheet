<?php
/*
 *  Copyright 2012 Native5. All Rights Reserved 
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *	You may not use this file except in compliance with the License.
 *		
 *	You may obtain a copy of the License at
 *	http://www.apache.org/licenses/LICENSE-2.0
 *  or in the "license" file accompanying this file.
 *
 *	Unless required by applicable law or agreed to in writing, software
 *	distributed under the License is distributed on an "AS IS" BASIS,
 *	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *	See the License for the specific language governing permissions and
 *	limitations under the License.
 *
 */

/**
 * 
 * @version 
 * @license See attached NOTICE.md for details
 * @copyright See attached LICENSE for details
 *
 * Created : 28-11-2012
 * Last Modified : Wed Nov 28 16:27:35 2012
 */
namespace Native5\Tests\Identity;

use Native5\Services\Identity\RemoteAuthenticationService;
use Native5\Identity\UsernamePasswordToken;
use Native5\Identity\SimpleAuthInfo;
use Native5\Identity\AuthenticationException;
use Guzzle\Http\Message\Response;

class IdentityServiceTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @var Guzzle\Http\Client
     */
    protected $_mockClient;


    /**
     * @var Native5\Core\Log\Logger
     */
    protected $_logger;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->_mockClient =  $this->getMock('Guzzle\Http\Client', array('send'));
        $this->_logger = $GLOBALS['logger'];
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }


    /**
     * testAuthSuccess 
     * 
     * @access public
     * @return void
     */
    public function testAuthSuccess()
    {
        $resp = new \Guzzle\Http\Message\Response(
            "200", 
            array('Content-Type'=>'application/json'), 
            '{"displayName":"barry", "email":"barry@native5.com", "account":"ACC_01010"}'
        );
        $mockClient = $this->getMock('Guzzle\Http\Client', array('send'));
        $authService = new RemoteAuthenticationService();
        $authService->setRemoteClient($this->_mockClient);
        $this->_mockClient->expects($this->once())
            ->method('send')
            ->will($this->returnValue($resp));
        $token = new UsernamePasswordToken('barry@native5.com', 'Awq21sdfjqe2');
        $authInfo = $authService->authenticate($token);
        $this->assertInstanceOf('Native5\Identity\SimpleAuthInfo', $authInfo);
    }

    /**
     * testAuthError
     *
     * @expectedException  Native5\Identity\AuthenticationException 
     * 
     * @access public
     * @return void
     */
    public function testAuthError()
    {
        $authService = new RemoteAuthenticationService();
        $token = new UsernamePasswordToken('barry@native5.com', 'Awq21sdfjqe2');
        $authInfo = $authService->authenticate($token);
    }


    /**
     * testAuthFailure 
     * 
     * @expectedException  Native5\Identity\AuthenticationException 
     */
    public function testAuthFailure()
    {
        $resp = new \Guzzle\Http\Message\Response(
            "200", 
            array('Content-Type'=>'application/json'), 
            '{"displayName":"barry", "email":"barry@native5.com", "account":"ACC_01010"}'
        );
        $mockClient = $this->getMock('Guzzle\Http\Client', array('send'));
        $authService = new RemoteAuthenticationService();
        $authService->setRemoteClient($this->_mockClient);
        $this->_mockClient->expects($this->once())
            ->method('send')
            ->will($this->throwException(new \Exception()));
        $token = new UsernamePasswordToken('barry@native5.com', 'Awq21sdfjqe2');
        $authInfo = $authService->authenticate($token);
    }
}
