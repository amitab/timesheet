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
 * @category  Api
 * @package   Native5\Core\<package>
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */

namespace Native5\Services\Common;

use Guzzle\Common\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


/**
 * HmacSignaturePlugin
 *
 * @category  Api
 * @package   Native5\Core\Api
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0
 * @link      http://www.docs.native5.com
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class HmacSignaturePlugin implements EventSubscriberInterface
{

    private $_options;


    /**
     * Constructor
     *
     * @param array $options Signing options
     */
    public function __construct(array $options)
    {
        $this->_options = $options;

    }//end __construct()


    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            'request.before_send' => 'onBeforeSend'
        );
    }


    /**
     * Sign HTTP request. 
     * This implementation curently supports following signature algorithms: 
     * "hmac-sha1", "hmac-sha256", "hmac-sha512"
     *
     * @param Event $event
     */
    public function onBeforeSend(Event $event)
    {
        global $logger;
        $req        = $event['request'];
        $options    = $this->_options;
        $algorithms = array(
            'sha1',
            'sha256',
            'sha512'
        );

        if (!isset($options['keyId']) || !is_string($options['keyId']))
            throw new \Exception("options.keyId must be a String");
        if (isset($options['algorithm']) && !is_string($options['algorithm']))
            throw new \Exception("options.algorithm must be a String");
        if (isset($options['headers']) && !is_array($options['headers']))
            throw new \Exception("options.headers must be an array of Strings");

        if ($req->getHeader('date') === null) {
            $req->setHeader('Date', $this->_rfc1123());
        }

        if (!isset($options['headers'])) {
            $options['headers'] = array(); 
        } 
        
        if (!in_array('Date', $options['headers'])) {
            $options['headers'][]= 'Date'; 
        }
        if (!in_array('X-Hmac-Nonce', $options['headers'])) {
            $options['headers'][]= 'X-Hmac-Nonce'; 
        }
        $req->setHeader('X-HMAC-Date', $this->_rfc1123());
        $req->setHeader('X-HMAC-Nonce', 'Thohn2Mohd2zugoo');

        $headersToSign = array();
        foreach($options['headers'] as $hdr) {
            $headersToSign[$hdr] = $req->getHeader($hdr); 
        } 
        
        if (!isset($options['algorithm']))
            $options['algorithm'] = 'sha512';
        $options['algorithm'] = strtolower($options['algorithm']);

        if (!in_array($options['algorithm'], $algorithms))
            throw new \Exception($options['algorithm']." is not supported");

        $canonicalRepresentation = HmacUtils::createCanonicalRepresentation($req->getMethod(), $headersToSign, $req->getUrl());
        $signature = HmacUtils::computeSignature($canonicalRepresentation, $options['key'], $options['algorithm']);
        $logger->debug('Canonical Representation ', array($canonicalRepresentation, $signature)); 
        $req->setHeader('Authorization', $options['algorithm'].' '.$options['keyId'].' '.$signature);
    }

    /**
     * Returns curent fate time in RFC1123 format, using UTC time zone
     *
     * @return string
     */
    private function _rfc1123()
    {
        $date = new \DateTime(null, new \DateTimeZone("GMT"));
        return str_replace("+0000", "GMT", $date->format(\DateTime::RFC1123));
    }

}
?>
