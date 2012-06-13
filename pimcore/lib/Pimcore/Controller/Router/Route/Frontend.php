<?php
/**
 * Pimcore
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.pimcore.org/license
 *
 * @copyright  Copyright (c) 2009-2010 elements.at New Media Solutions GmbH (http://www.elements.at)
 * @license    http://www.pimcore.org/license     New BSD License
 */

class Pimcore_Controller_Router_Route_Frontend extends Zend_Controller_Router_Route_Abstract {

    /**
     * @var array
     */
    protected $redirects = array();

    /**
     * @var array
     */
    public $_defaults = array();

    /**
     * @var string
     */
    protected $nearestDocumentByPath;

    /**
     * @return int
     */
    public function getVersion() {
        return 1;
    }

    /**
     * @static
     * @param Zend_Config $config
     * @return Pimcore_Controller_Router_Route_Frontend
     */
    public static function getInstance(Zend_Config $config) {
        return new self();
    }


    /**
     * @param  $path
     * @param bool $partial
     * @return array|bool
     */
    public function match($path, $partial = false) {
                
        $matchFound = false;
        $config = Pimcore_Config::getSystemConfig();

        $routeingDefaults = Pimcore_Tool::getRoutingDefaults();

        $params = array_merge($_GET, $_POST);
        $params = array_merge($routeingDefaults, $params);
        
        // set the original path
        $originalPath = $path;
        
        // check for a registered site
        try {
            if ($config->general->domain != Pimcore_Tool::getHostname()) {
                $domain = Pimcore_Tool::getHostname();
                $site = Site::getByDomain($domain);
                $site->setRootPath($site->getRootDocument()->getFullPath());
                $path = $site->getRootDocument()->getFullPath() . $path;

                Zend_Registry::set("pimcore_site", $site);
            }
        }
        catch (Exception $e) {}


        // check for direct definition of controller/action
        if (!empty($_REQUEST["controller"]) && !empty($_REQUEST["action"])) {
            $matchFound = true;
            //$params["document"] = $this->getNearestDocumentByPath($path);
        }
        
        // you can also call a page by it's ID /?pimcore_document=XXXX
        if (!$matchFound) {
            if(!empty($params["pimcore_document"]) || !empty($params["pdid"])) {
                $doc = Document::getById($params["pimcore_document"] ? $params["pimcore_document"] : $params["pdid"]);
                if($doc instanceof Document) {
                    $path = $doc->getFullPath();
                }
            }
        }

        // test if there is a suitable redirect with override = all (=> priority = 99)
        if (!$matchFound) {
            $this->checkForRedirect(true);
        }

        // test if there is a suitable page
        if (!$matchFound) {
            try {
                $document = Document::getByPath($path);

                // check for a parent hardlink with childs
                if(!$document instanceof Document) {
                    $hardlinkedParentDocument = $this->getNearestDocumentByPath($path, true);
                    if($hardlinkedParentDocument instanceof Document_Hardlink) {
                        if($hardLinkedDocument = Document_Hardlink_Service::getChildByPath($hardlinkedParentDocument, $path)) {
                            $document = $hardLinkedDocument;
                        }
                    }
                }

                // check for direct hardlink
                if($document instanceof Document_Hardlink) {
                    $hardlinkParentDocument = $document;
                    $document = Document_Hardlink_Service::wrap($hardlinkParentDocument);
                }

                if ($document instanceof Document) {
                    if (in_array($document->getType(), array("page","snippet","email"))) {

                        if (!empty($params["pimcore_version"]) || !empty($params["pimcore_preview"]) || !empty($params["pimcore_admin"]) || !empty($params["pimcore_editmode"]) || $document->isPublished() ) {

                            // check for a pretty url, and if the document is called by that, otherwise redirect to pretty url
                            if($document instanceof Document_Page && $document->getPrettyUrl() && empty($params["pimcore_preview"]) && empty($params["pimcore_editmode"])) {
                                if(rtrim($document->getPrettyUrl()) != rtrim($path,"/")) {
                                    header("Location: " . $document->getPrettyUrl(), true, 301);
                                    exit;
                                }
                            }

                            $params["document"] = $document;
                            if ($controller = $document->getController()) {
                                $params["controller"] = $controller;
                                $params["action"] = "index";
                            }
                            if ($action = $document->getAction()) {
                                $params["action"] = $action;
                            }
                            if ($module = $document->getModule()) {
                                $params["module"] = $module;
                            }

                            // check for a trailing slash in path, if exists, redirect to this page without the slash
                            // the only reason for this is: SEO, Analytics, ... there is no system specific reason, pimcore would work also with a trailing slash without problems
                            // use $originalPath because of the sites
                            // only do redirecting with GET requests
                            if(strtolower($_SERVER["REQUEST_METHOD"]) == "get") {
                                if($config->documents->allowtrailingslash) {
                                    if($config->documents->allowtrailingslash == "no") {
                                        if(substr($originalPath, strlen($originalPath)-1,1) == "/" && $originalPath != "/") {
                                            $redirectUrl = rtrim($originalPath,"/");
                                            if($_SERVER["QUERY_STRING"]) {
                                                $redirectUrl .= "?" . $_SERVER["QUERY_STRING"];
                                            }
                                            header("Location: " . $redirectUrl, true, 301);
                                            exit;
                                        }
                                    }
                                }

                                if($config->documents->allowcapitals) {
                                    if($config->documents->allowcapitals == "no") {
                                        if(strtolower($originalPath) != $originalPath) {
                                            $redirectUrl = strtolower($originalPath);
                                            if($_SERVER["QUERY_STRING"]) {
                                                $redirectUrl .= "?" . $_SERVER["QUERY_STRING"];
                                            }
                                            header("Location: " . $redirectUrl, true, 301);
                                            exit;
                                        }
                                    }
                                }
                            }

                            $matchFound = true;
                        }
                    } else if ($document->getType() == "link")  {
                        // if the document is a link just redirect to the location/href of the link
                        header("Location: " . $document->getHref(),true,301);
                        exit;
                    }
                }
            }
            catch (Exception $e) {
                // no suitable page found
            }
        }

        // test if there is a suitable static route
        if (!$matchFound) {
            try {
                
                $cacheKey = "system_route_staticroute";
                if (!$routes = Pimcore_Model_Cache::load($cacheKey)) {
                
                    $list = new Staticroute_List();
                    $list->setOrderKey("priority");
                    $list->setOrder("DESC");
                    $routes = $list->load();
                    
                    Pimcore_Model_Cache::save($routes, $cacheKey, array("system","staticroute","route"), null, 998);
                }
                
                foreach ($routes as $route) {

                    if (@preg_match($route->getPattern(), $originalPath) && !$matchFound) {
                        $params = array_merge($route->getDefaultsArray(), $params);

                        $variables = explode(",", $route->getVariables());

                        preg_match_all($route->getPattern(), $originalPath, $matches);

                        if (is_array($matches) && count($matches) > 1) {
                            foreach ($matches as $index => $match) {
                                if ($variables[$index - 1]) {
                                    $params[$variables[$index - 1]] = urldecode($match[0]);
                                }
                            }
                        }

                        $controller = $route->getController();
                        $action = $route->getAction();
                        $module = trim($route->getModule());

                        // check for dynamic controller / action / module
                        $dynamicRouteReplace = function ($item, $params) {
                            if(strpos($item, "%") !== false) {
                                foreach ($params as $key => $value) {
                                    $dynKey = "%" . $key;
                                    if(strpos($item, $dynKey) !== false) {
                                        return str_replace($dynKey, $value, $item);
                                    }
                                }
                            }
                            return $item;
                        };

                        $controller = $dynamicRouteReplace($controller, $params);
                        $action = $dynamicRouteReplace($action, $params);
                        $module = $dynamicRouteReplace($module, $params);

                        $params["controller"] = $controller;
                        $params["action"] = $action;
                        if(!empty($module)){
                            $params["module"] = $module;
                        }

                        // try to get nearest document to the route
                        $document = $this->getNearestDocumentByPath($path, false, array("page", "snippet", "hardlink"));
                        if($document instanceof Document_Hardlink) {
                            $document = Document_Hardlink_Service::wrap($document);
                        }
                        $params["document"] = $document;

                        $matchFound = true;
                        Staticroute::setCurrentRoute($route);

                        break;
                    }
                }
            }
            catch (Exception $e) {
                // no suitable route found
            }
        }
        
        // test if there is a suitable redirect
        if (!$matchFound) {
            $this->checkForRedirect(false);
        }

        if (!$matchFound) {
            return false;
        }
        
        // remove pimcore magic parameters
        unset($params["pimcore_outputfilters_disabled"]); 
        unset($params["pimcore_document"]);
        unset($params["nocache"]);
        
        return $params;
    }


    /**
     * @param $path
     * @param bool $ignoreHardlinks
     * @param array $types
     * @return Document|Document_PageSnippet|null|string
     */
    protected function getNearestDocumentByPath ($path, $ignoreHardlinks = false, $types = array()) {

        if($this->nearestDocumentByPath instanceof Document) {
            $document = $this->nearestDocumentByPath;
        } else {

            $pathes = array();

            $pathes[] = "/";
            $pathParts = explode("/", $path);
            $tmpPathes = array();
            foreach ($pathParts as $pathPart) {
                $tmpPathes[] = $pathPart;
                $t = implode("/", $tmpPathes);
                if (!empty($t)) {
                    $pathes[] = $t;
                }
            }

            $pathes = array_reverse($pathes);

            foreach ($pathes as $p) {
                if ($document = Document::getByPath($p)) {
                    if(empty($types) || in_array($document->getType(), $types)) {
                        $this->nearestDocumentByPath = $document;
                        break;
                    }
                }
            }
        }

        if($document) {
            if(!$ignoreHardlinks) {
                if($document instanceof Document_Hardlink) {
                    if($hardLinkedDocument = Document_Hardlink_Service::getChildByPath($document, $path)) {
                        $document = $hardLinkedDocument;
                    } else {
                        $document = Document_Hardlink_Service::wrap($document);
                    }
                }
            }
            return $document;
        }

        return null;
    }

    /**
     * Checks for a suitable redirect
     * @throws Exception
     * @param bool $override
     * @return void
     */
    protected function checkForRedirect ($override = false) {
        try {

            $cacheKey = "system_route_redirect";
            if (empty($this->redirects) && !$this->redirects = Pimcore_Model_Cache::load($cacheKey)) {

                $list = new Redirect_List();
                $list->setOrder("DESC");
                $list->setOrderKey("priority");
                $this->redirects = $list->load();

                Pimcore_Model_Cache::save($this->redirects, $cacheKey, array("system","redirect","route"), null, 998);
            }

            foreach ($this->redirects as $redirect) {

                // if override is true the priority has to be 99 which means that overriding is ok
                if(!$override || ($override && $redirect->getPriority() == 99)) {
                    if (@preg_match($redirect->getSource(), $_SERVER["REQUEST_URI"], $matches)) {

                        array_shift($matches);

                        $target = $redirect->getTarget();
                        if(is_numeric($target)){
                            $d = Document::getById($target);
                            if($d instanceof Document_Page){
                                $target = $d->getFullPath();
                            } else {
                                throw new Exception("Target of redirect no found!");
                            }
                        }

                        // replace escaped % signs so that they didn't have effects to vsprintf (PIMCORE-1215)
                        $target = str_replace("\\%","###URLENCODE_PLACEHOLDER###", $target);
                        $url = vsprintf($target, $matches);
                        $url = str_replace("###URLENCODE_PLACEHOLDER###", "%", $url);

                        header($redirect->getHttpStatus());
                        header("Location: " . $url, true, $redirect->getStatusCode());

                        // log all redirects to the redirect log
                        Pimcore_Log_Simple::log("redirect", Pimcore_Tool::getClientIp() . " \t Source: " . $_SERVER["REQUEST_URI"] . " -> " . $url);
                        exit;
                    }
                }
            }
        }
        catch (Exception $e) {
            // no suitable route found
        }
    }

    public function assemble($data = array(), $reset = false, $encode = true, $partial = false) {
        return "~NOT~SUPPORTED~";
    }

    public function getDefault($name) {
        if (isset($this->_defaults[$name])) {
            return $this->_defaults[$name];
        }
    }

    public function getDefaults() {
        return $this->_defaults;
    }

}
