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
 * @category  Controllers 
 * @package   Native5\Control
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */

namespace Native5\Control;

use Native5\Sessions\WebSessionManager;
use Native5\Route\HttpResponse;

/**
 * DefaultController 
 *
 * @category  Controllers 
 * @package   Native5\Control
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0
 * @link      http://www.docs.native5.com
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
abstract class DefaultController implements Controller
{

    protected $_request;

    protected $_response;

    protected $command;

    private $_preProcessors;

    private $_postProcessors;


    /**
     * __construct 
     * 
     * @param mixed &$command Construct command to pass
     *
     * @access public
     * @return void
     */
    public function __construct(&$command)
    {
        $this->command         = $command;
        $this->_preProcessors  = array();
        $this->_postProcessors = array();

    }//end __construct()


    /**
     * Adds a PreProcessor {@see Native5\Control\PreProcessor} to the controller 
     * for handling requests before they are processed. Can be used to chain 
     * processors to execute a sequence of pre-processing steps. 
     * 
     * @param mixed $processor The processor to add.
     *
     * @access public
     * @return void
     * @throws \Exception Invalid Argument exception
     */
    public function addPreProcessor($processor)
    {
        if (($processor instanceof PreProcessor) === false) {
            throw new \Exception('Invalid Argument, processor must implement interface Native5\Control\PreProcessor');
        }

        return $this->_preProcessors[] = $processor;

    }//end addPreProcessor()


    /**
     * Handles Request Execution. 
     * 
     * @param mixed $request HttpRequest @see Native5/Route/HttpRequest 
     *
     * @access public
     * @return void
     */
    public function execute($request)
    {
        ob_start();
        $logger          = $GLOBALS['logger'];
        $this->_request  = $request;
        $this->_response = new HttpResponse();
        try {
            WebSessionManager::updateActiveSession();
            foreach ($this->_preProcessors as $preProcessor) {
                $preProcessor->process($this->_request);
            }

            $functionToCall = $this->command->getFunction();
            if (empty($functionToCall) === true) {
                $functionToCall = 'default';
            }

            if (!is_callable(array(&$this,'_'.$functionToCall))) {
                $functionToCall = 'error';
            }

            call_user_func(array(&$this,'_'.$functionToCall), $this->_request);
            foreach ($this->_postProcessors as $postProcessor) {
                $postProcessor->process($this->_response);
            }

            ob_end_clean();
            if (empty($this->_response)) {
                $this->_response = new HttpResponse(); 
            }

            if($this->_response->getEncoding() == null) {
                $responseMode = $this->_request->getParam('mode');
                if ($responseMode === 'ui') {
                    $this->_response->setEncoding('html');
                } else if ($responseMode === 'data') {
                    $this->_response->setEncoding('json');
                }
            }
            $this->_response->send();
        } catch (ServiceException $se) {
            $this->_response = new HttpResponse();
            $response->addHeader('HTTP/1.1 400 Bad Request');
            $this->_response->send();
        } catch(BadResponseException $bre) {
            $this->_response = new HttpResponse();
            $response->addHeader('HTTP/1.1 500 Internal Server Error');
            $this->_response->send();
        }//end try

    }//end execute()


    /**
     * Adding a post processor for processing responses before sending them. 
     * 
     * @param mixed $processor @see Native5\Control\PostProcessor
     *
     * @access public
     * @return void
     * @throws \Exception Invalid Argument exception
     */
    public function addPostProcessor($processor)
    {
        if(!($processor instanceof PostProcessor))
            throw new \Exception('Invalid Argument, processor must implement interface Native5\Control\PostProcessor');
        $this->_postProcessors[] = $processor;

    }//end addPostProcessor()


    /**
     * Default Request Handler. 
     * 
     * @param mixed $request Default request handler.
     *
     * @abstract
     * @access public
     * @return void
     */
    abstract public function _default($request);


    /**
     * Handles errors in case no path is found. 
     * 
     * @access public
     * @return void
     */
    public function _error()
    {
        echo "No such path found:<strong> ".$this->command->getControllerName().'/'.$this->command->getFunction()."</strong>";

    }//end _error()


    /**
     * getParams  
     * 
     * @access public
     * @return void
     */
    public function getParams()
    {
        return null;

    }//end getParams()


}//end class

?>
