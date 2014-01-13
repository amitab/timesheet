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
 * @category  Routing 
 * @package   Native5\Control
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Route;

use Native5\UI\SimpleRenderer;
use Native5\Sessions\WebSessionManager;

/**
 * HttpResponse
 * 
 * @category  Routing
 * @package   Native5\Control
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class HttpResponse implements Response
{

    private $_encoding;

    private $_headers;

    private $_body;

    private $_renderer;
    
    private $_error;


    /**
     * __construct 
     * 
     * @param string $encoding The default encoding
     * @param mixed  $renderer Renderer 
     *
     * @access public
     * @return void
     */
    public function __construct($encoding='none', $renderer=null)
    {
        $this->_encoding = $encoding;
        if($renderer == null)
            $renderer = new SimpleRenderer();
        $this->_renderer = $renderer;
        $this->_headers = array();
        $this->_error = false;

    }//end __construct()


    /**
     * redirectTo Helper method to allow redirection to a certain url. 
     * 
     * @param mixed $location 
     * @access public
     * @return void
     */
    public function redirectTo($location) {
        global $app;
        $host = $_SERVER['HTTP_HOST'];
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
        }
        $protocol = isset($_SERVER['HTTPS'])?'https://':'http://'; 
        $redirectLocation = $protocol.$host.'/'.$app->getConfiguration()->getApplicationContext().'/'.$location;
        if ($app->getSubject()->isAuthenticated()) {
            $separator = '?';
            if(strpos($redirectLocation, '?'))
                $separator = '&';
            $redirectLocation .= $separator."rand_token=".$app->getSessionManager()->getActiveSession()->getAttribute('nonce');
        }
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $response = array();
            $response['redirect'] = $redirectLocation;
            echo json_encode($response);
            exit;
        } else {
            $this->addHeader('Location: '.$redirectLocation);
        }
    }
    
    
    /**
     * sendError 
     * 
     * @param mixed $message 
     * @param int $code 
     * @access public
     * @return void
     */
    public function sendError($message, $code=500) {
        $this->_error = true;
        $statusHeader= "HTTP/1.1 ".$code." ".$message;
        header($statusHeader);
    }

    /**
     * send
     *
     * @access public
     * @return void
     */
    public function send()
    {
        if (!$this->_error) {
            foreach ($this->_headers as $value) {
                header($value);
            }//end foreach
            echo $this->_transform($this->_encoding, $this->_body);
        }
    }//end send()


    /**
     * sendFile 
     * 
     * @param mixed $filePath The file path
     *
     * @access public
     * @return void
     */
    public function sendFile($filePath) {
        header("X-Sendfile: $filePath");
        header('Content-type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filePath).'"');

    }//end sendFile()


    /**
     * getMetadata
     *
     * @access public
     * @return void
     */
    public function getMetadata()
    {
        return $this->_headers;

    }//end getMetadata()


    /**
     * getBody 
     * 
     * @access public
     * @return void
     */
    public function getBody()
    {
        return $this->_body;

    }//end getBody()


    /**
     * setHeaders  
     * 
     * @param mixed $headers Headers for response 
     *
     * @access public
     * @return void
     */
    public function setHeaders($headers)
    {
        $this->_headers = $headers;

    }//end setHeaders()


    /**
     * addHeader 
     * 
     * @param mixed $header Header to add
     *
     * @access public
     * @return void
     */
    public function addHeader($header)
    {
        //TODO : Add Duplicate check here
        $this->_headers[] = $header;

    }//end addHeader()


    /**
     * setBody 
     * 
     * @param mixed $body Body of response
     *
     * @access public
     * @return void
     */
    public function setBody($body)
    {
        $this->_body = $body;

    }//end setBody()


    /**
     * setMode 
     * 
     * @param mixed $encoding Encoding format i.e xml, html, json, none
     *
     * @access public
     * @return void
     */
    public function setEncoding($encoding)
    {
        $this->_encoding = $encoding;

    }//end setEncoding()


    /**
     * getEncoding 
     * 
     * @access public
     * @return void
     */
    public function getEncoding()
    {
        return $this->_encoding;

    }//end getEncoding()


    /**
     * _transform 
     * 
     * @param mixed $encoding Encoding to use  
     * @param mixed $data     Data to encode 
     *
     * @access private
     * @return void
     */
    private function _transform($encoding, $data)
    {
        global $logger;
        switch($encoding) {
        case 'none' :
            header('Content-Type: text/html');
            return $this->_renderer->render($data);
        case 'json' :
            header('Content-Type: application/json');
            $output = array();
            $output['code'] = 200;
            $output['message'] = $this->_renderer->render($data);
            return json_encode($output);
        default :
            return $data;
        }

    }//end _transform()


}//end class

?>
