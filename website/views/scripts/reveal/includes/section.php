<?php
/**
 * Created by elements.at New Media Solutions GmbH
 * Nikolaus Flamann
 * File: section.php
 * User: nflamann
 * Date: 16.07.12
 * Time: 23:10
 *
 * @var $this Pimcore_View
 */

if ($this->editmode or (strlen($this->input("headline")) > 0)) {


    ?>
<h1><?=$this->input("headline");?></h1>
<?php
}
if (strlen($this->input("headline")) < 2) {
    if ($this->editmode or (strlen($this->input("subheadline")) > 0)) {
        ?>
    <h2><?=$this->input("subheadline");?></h2>
    <?php
    }
}

if ($this->editmode or (strlen($this->input("thirdheadline")) > 0)) {
    ?>
<h3 class="inverted"><?=$this->input("thirdheadline");?></h3>
<?php
}

?>
<div class="textblock <?=$this->select("textstyle")->getValue();?>">
    <?php

    if ($this->editmode) {
        echo "Textausrichtung";
        $store = array(array("center", "Zentriert (default)"), array("left", "Links"));

        echo $this->select("textstyle", array("store" => $store));

    }


    echo $this->wysiwyg("content");


    if ($this->editmode) {
        echo "<div class=\"code\">CodeSample: ";
        echo $this->textarea("codeSample", array("nl2br"  => true, "width"  => 780, "height" => 300));
        echo "</div>";
    }
    else if (strlen($this->textarea("codeSample")->getValue()) > 0) {
        ?>
        <pre>
            <code contenteditable><?= trim($this->textarea("codeSample", array("nl2br"  => true, "width"  => 780, "height" => 600)));?></code>
        </pre>
        <?php
    }
    ?>
</div>

