<?php
/*
 *  Copyright 2012 Native5. All Rights Reserved 
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  You may not use this file except in compliance with the License.
 *              
 *  You may obtain a copy of the License at
 *  http://www.apache.org/licenses/LICENSE-2.0
 *  or in the "license" file accompanying this file.
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *  PHP version 5.3+
 *
 * @category  Application
 * @package   Native5\Application\
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */

namespace Native5\UI;
use Native5\Sessions\WebSessionManager;

/**
 * TemplatingEngine 
 *
 * @category  UI 
 * @package   Native5\UI
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0
 * @link      http://www.docs.native5.com
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class TemplatingEngine
{

    protected $_renderer;

    private $_viewData;

    public function __construct( $renderer=NULL ) {
        if($renderer == NULL)
            $this->init();
    }

    // Default initialization in case no renderer 
    private function init() {
        $this->_viewData = array();
        $this->configureRenderer();
        $this->initializeView();
    }

    private function configureRenderer() {
        global $app;
        $session = $app->getSessionManager()->getActiveSession();
        $templates_path = "templates/".$session->getAttribute('category');

        $commonPath = 'templates/common';
        if ($app->getConfiguration()->isLocal()) {
            $commonPath = 'views'.'/'.$commonPath;
        } 
        if($app->getConfiguration()->isLocal()) {
            $templates_path = 'views'.'/'.$templates_path;
        }
        
        $pathsToSearch = array();
        if (file_exists($templates_path)) {
            $pathsToSearch[] = $templates_path;
        }
        $pathsToSearch[] = $commonPath;
        $loader         =  new \Twig_Loader_Filesystem($pathsToSearch);
        // Configure renderer
        $cache_path = defined('CACHE_PATH') ? CACHE_PATH : "cache";
        
        $cacheFolder =  getcwd().DIRECTORY_SEPARATOR.$cache_path;
        if (!file_exists($cacheFolder)) {
            if(!mkdir($cacheFolder)) {
                $cacheFolder = sys_get_temp_dir().$cache_path;
                if(!file_exists($cacheFolder) && !mkdir($cacheFolder)) {
                    die('Insufficient privileges to create logs folder in application directory, or temp path, exiting');    
                }
            }
        }

        $this->_renderer = new \Twig_Environment(
            new \Twig_Loader_Filesystem($pathsToSearch, 
            array(
                'debug'=> true,
                'autoreload'=>false,
                'autoescape'=>true,
                'cache' => $cacheFolder
            )
        )
    );
        $this->_renderer->getExtension('core')->setNumberFormat(2, '.', ',');
        $this->_renderer->addFilter('truncate', new \Twig_Filter_Function("StringFilter::truncate"));
        $this->_renderer->addFilter('isToday', new \Twig_Filter_Function("DateFilter::isToday"));
        $this->_renderer->addFilter('isTomorrow', new \Twig_Filter_Function("DateFilter::isTomorrow"));
        $this->_renderer->addFilter('isLater', new \Twig_Filter_Function("DateFilter::isLater"));
    }

    private function initializeView()
    {
        global $app;
        $settings = array();
        $settings['home'] = 'http://'; 

        $globalStyles  = array();
        $globalScripts = array();

        if($app->isDebugMode()) {
            $globalScripts[] = 'native5.core';
            $globalScripts[] = 'native5.core.analytics';
            $globalScripts[] = 'native5.core.networks';
            $globalScripts[] = 'native5.core.storage';
            $globalStyles[]  = 'native5.base';
        } else {
            $globalScripts[] = 'native5.min';
            $globalStyles[]  = 'native5.base.min';
        }

        $session = $app->getSessionManager()->getActiveSession();
        $this->_viewData['styles']   = $globalStyles;
        $this->_viewData['device']   = array('category'=>$session->getAttribute('category'));
        $this->_viewData['settings'] = $settings;
    }


    /**
     * Renders a given template along with input data.  
     * 
     * @param mixed $tmpl    The template to render.
     * @param mixed $in_data The data to render with.
     *
     * @access protected
     * @return void
     */
    protected function render($tmpl, $in_data=array()) {
        try {
            $data            = array();
            $app             = array();
            $app['content']  = $in_data;
            $app['settings'] = $this->_viewData['settings'];

            $data['app']     = $app; 
            $data['global']  = array('styles'=>$this->_viewData['styles']);
            $data['device']  = $this->_viewData['device'];

            return $this->_renderer->render($tmpl, $data);
        } catch (\Exception $e) {
            return 'Issues with data, cannot be rendered';
        }//end try

    }//end render()


}//end class

?>
