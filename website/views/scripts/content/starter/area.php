<?php
/**
 * Area
 *
 * @var $this Pimcore_View
 * @url http://www.pimcore.org/wiki/display/PIMCORE/Area+%28since+1.4.3%29
 */

$this->layout()->setLayout("default");
?>

<div class="contentblock">
    <?php

    echo $this->area("myArea", array(
        "type" => "googleanalyticstagcloud"
    ));
    ?>
</div>