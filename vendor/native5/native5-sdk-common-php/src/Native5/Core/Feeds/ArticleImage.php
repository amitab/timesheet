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

namespace Native5\Core\Feeds;

/**
 * ArticleImage 
 * 
 * @category  Core 
 * @package   Native5\Core\Feeds
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created :  06-Nov-2013 
 * Last Modified : Wed Nov  6 09:18:22 2013
 */
class ArticleImage
{
    
    public $url, $width, $height, $res;


    /**
     * __construct 
     * 
     * @param mixed $image The image to parse.
     *
     * @access public
     * @return void
     */
    public function __construct($image)
    {
        $this->url = $image;
        $this->_computeResolution($image);
    }


    /**
     * getResolution 
     * 
     * @access public
     * @return void
     */
    public function getResolution()
    {
        return $this->res;
    }


    /**
     * computeResolution 
     * 
     * @param mixed $image The image to parse
     *
     * @access private
     * @return void
     */
    private function _computeResolution($image)
    {
        $this->res = "MED";
        if(preg_match("/HiRes/i", $image))
            $this->res = "HIGH";
        elseif (preg_match("/LowRes/i", $image))
            $this->res = "LOW";
        elseif (preg_match("/Thumb/i", $image))
            $this->res = "THUMB";
        elseif (preg_match("/MediumRes/i", $image))
            $this->res = "MED";
    }

}

