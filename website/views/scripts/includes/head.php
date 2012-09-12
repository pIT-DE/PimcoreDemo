<?php
/**
 * Head Management
 *
 * @info ~~nocodeview
 *
 * @var $this Pimcore_View
 */

$language = Zend_Registry::get("Zend_Locale")->getLanguage();

$this->headTitle()->setSeparator(" " . $this->translate("|") . " ");

$this->headTitle($this->translate("Pimcore Demo Project"));

if (!$this->editmode and $this->document instanceof Document) {

    if (strlen($this->document->getDescription()) > 0) {
        $this->headMeta()->appendHttpEquiv('description', $this->document->getDescription());
    } else if ($this->placeholder("metaset")->getValue() === true) {
        // Content is set
    } else {
        $this->headMeta()->appendHttpEquiv('description', $this->translate("head.description"));
    }

    if (strlen($this->document->getKeywords()) > 0) {
        $this->headMeta()->appendHttpEquiv('keywords', $this->document->getKeywords());
    }

    echo $this->headMeta();
}

/**
 * Load My CSS Files
 */

$this->headLink()->prependStylesheet(
    array(
        'href' => '/static/css/layout.css',
        'rel' => 'stylesheet',
        'media' => 'all',
        'type' => 'text/css'
    )
);

if ($this->_getParam("pimcore"))     {


    $this->headLink()->appendStylesheet(
        array(
            'href' => '/static/css/styles.less',
            'rel' => 'stylesheet/less',
            'media' => 'screen',
            'type' => 'text/less'
        )
    );
    $this->headLink()->appendStylesheet(
        array(
            'href' => '/static/css/style.css',
            'rel' => 'stylesheet',
            'media' => 'screen',
            'type' => 'text/css'
        )
    );
}
if ($this->placeholder("colorbox")->getValue() === true) {

    $this->headLink()->appendStylesheet(
        array(
            'href' => '/static/css/colorbox.css',
            'rel' => 'stylesheet',
            'media' => 'screen',
            'type' => 'text/css'
        )
    );
}
if ($this->document instanceof Document_Page and $this->document->getProperty("codeview")) {
    $pluginpath = "/static/plugins/syntaxhighlighter_3.0.83";

    $this->headLink()->appendStylesheet(
        array(
            'href' => '/static/css/colorbox.css',
            'href' => $pluginpath . '/styles/shCoreDefault.css',
            'rel' => 'stylesheet',
            'media' => 'screen',
            'type' => 'text/css'
        ));

    /**
     * @note revert Order ! --> prepend
     */
    $this->headScript()->prependFile(
        $pluginpath . '/scripts/shBrushPhp.js',
        'text/javascript'
    );
    $this->headScript()->prependFile(
        $pluginpath . '/scripts/shCore.js',
        'text/javascript'
    );
    $this->headScript()->appendScript(
        "SyntaxHighlighter.all()"
    );

}


if ($this->editmode) {

    $this->headLink()->appendStylesheet(
        array(
            'href' => '/static/css/editmode.css',
            'rel' => 'stylesheet',
            'media' => 'all',
            'type' => 'text/css'
        )
    );
}

$this->headLink()->appendStylesheet(
    array(
        'href' => '/static/css/print.css',
        'rel' => 'stylesheet',
        'media' => 'print',
        'type' => 'text/css'
    ));

$this->headLink()->appendStylesheet('/static/css/ie.css', 'screen', 'lt IE 9');

/**
 * Output all Header Information
 */

echo $this->headTitle();
echo $this->headStyle();
echo $this->headLink();

if (!Pimcore_Google_Analytics::isConfigured() and !Pimcore_Google_Analytics::getCode()) {
    ?>
<script type="text/javascript" language="JavaScript">
    /*<![CDATA[*/
    var _gaq = _gaq || [];
    /*]]>*/
</script>
<?php
}

