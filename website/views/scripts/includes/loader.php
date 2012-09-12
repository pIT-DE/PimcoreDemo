<?php
/**
 * My JavaScript
 * @var $this Pimcore_View
 */


$this->headScript()->prependFile(
    '/static/js/lib/jquery-1.8.1.min.js',
    'text/javascript'
);

if ($this->placeholder("lightbox")->getValue() === true) {
    $this->headScript()->appendFile(
        '/static/js/colorbox/jquery.colorbox-min.js',
        'text/javascript'
    );
}


if (!$this->editmode) {
    $this->headScript()->appendFile(
        '/static/js/script.js',
        'text/javascript'
    );
}

$ie6 = <<<EOD
window.attachEvent("onload", function () {
    CFInstall.check({mode:"overlay"})
});
EOD;

$this->headScript()->appendFile("//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js",null, array('conditional' => 'IE 6'));
$this->headScript()->appendScript($ie6,null, array('conditional' => 'IE 6'));

echo $this->headScript();

