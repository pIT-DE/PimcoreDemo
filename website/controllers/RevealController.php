<?php

/**
 * Created by elements.at New Media Solutions GmbH
 * Nikolaus Flamann
 * File: TrainingController.php
 * User: nflamann
 * Date: 16.07.12
 * Time: 21:52
 *
 * @var $this Pimcore_View
 */
class RevealController extends Website_Controller_Action
{

    const REVALPATH = "/static/plugins/reveal.js";

    public function init ()
    {
        parent::init();
        
        $this->enableLayout();
        
        $this->view->hasOwnStyles = true;
        
        if (! $this->editmode) {
            $this->view->headLink()->appendStylesheet(
                    array(
                            'href' => self::REVALPATH . '/css/reset.css',
                            'rel' => 'stylesheet'
                    ));
        }
        
        $this->view->headLink()->appendStylesheet(
                array(
                        'href' => self::REVALPATH . '/css/main.css',
                        'rel' => 'stylesheet'
                ));
        $this->view->headLink()->appendStylesheet(
                array(
                        'href' => self::REVALPATH . '/lib/css/zenburn.css',
                        'rel' => 'stylesheet'
                ));
        $this->view->headLink()->appendStylesheet(
                array(
                        'href' => self::REVALPATH . '/css/print.css',
                        'rel' => 'stylesheet',
                        'media' => 'print',
                        'type' => 'text/css'
                ));
        $this->view->headLink()->appendStylesheet(
                array(
                        'href' => '/static/css/reveal.css',
                        'rel' => 'stylesheet'
                ));
        
        $this->view->hasOwnScripts = true;
        
        $this->view->headScript()->appendFile(
                '/static/js/backstretch/jquery.backstretch.js', 
                'text/javascript');
        
        $this->view->headScript()->appendFile(
                self::REVALPATH . '/lib/js/head.min.js', 'text/javascript');
        
        $this->view->headScript()->appendFile(
                self::REVALPATH . '/js/training.js', 'text/javascript');
    }

    public function presentationAction ()
    {
        $this->view->isSub = $this->_getParam("isSub");
    }
}
