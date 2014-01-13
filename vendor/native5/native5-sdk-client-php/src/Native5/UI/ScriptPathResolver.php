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
 * @category  Filters 
 * @package   Native5\UI
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com 
 */

namespace Native5\UI;

/**
 * ScriptPathResolver 
 * 
 * @category  Filters 
 * @package   Native5\UI
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class ScriptPathResolver
{


    /**
     * Resolve Script Path based on name. 
     * 
     * @param mixed $name Name of the script to resolve.
     *
     * @access public
     * @return void
     */
    public static function resolve($name)
    {
        $logger     = $GLOBALS['logger'];
        $app        = $GLOBALS['app'];
        $staticPath = 'public';
        
        if ($app->getConfiguration()->isLocal()) {
            $staticPath = 'views';
        }

        $session    = $app->getSessionManager()->getActiveSession();
        $category   = $session->getAttribute('category');
        $basePath   = '/'.$staticPath.'/resources/'.$category;
        $commonPath = '/'.$staticPath.'/resources/common';

        $searchFolder = '.';
        
        $isUrl = false;

        if(preg_match('/.*\.js$/', $name)) {
            $searchFolder = 'scripts';
        } else if(preg_match('/.*\.css$/', $name)) {
            $searchFolder = 'styles';
        } else if(preg_match('/.*\.(?:jpg|jpeg|gif|png)$/', $name)) {
            $searchFolder = 'images';
        } else {
            $isUrl = true;
            $name  = DIRECTORY_SEPARATOR.$app->getConfiguration()->getApplicationContext().DIRECTORY_SEPARATOR.$name;
        }

        if ($isUrl) {
            return $name;
        }

        if (file_exists(getcwd().$basePath.'/'.$searchFolder.'/'.$name)) {
            return '/'.$app->getConfiguration()->getApplicationContext().$basePath.'/'.$searchFolder.'/'.$name;
        } else if (file_exists(getcwd().$commonPath.'/'.$searchFolder.'/'.$name)) {
            return '/'.$app->getConfiguration()->getApplicationContext().$commonPath.'/'.$searchFolder.'/'.$name;
        }
        return $name;
    }


    /**
     * secureLink
     * 
     * @param mixed $url Append nonce to token.
     *
     * @static
     * @access public
     * @return void
     */
    public static function secureLink($url)
    {
        $app        = $GLOBALS['app'];
        if ($app->getSubject() !== null && $app->getSubject()->isAuthenticated()) {
            $separator = '&';
            if(!strpos($url, '?')) {
                $separator = '?';
            }
            $url = $url.$separator.'rand_token='.$app->getSessionManager()->getActiveSession()->get('nonce');
        }
    }//end resolveLink()
}
?>
