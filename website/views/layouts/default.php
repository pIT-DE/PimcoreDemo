<?
/**
 * Main Layout
 *
 * Created by elements.at New Media Solutions GmbH
 * Nikolaus Flamann
 * File: default.php
 * User: Nflamann
 *
 * @var $this Pimcore_View
 *
 */

$language = Zend_Registry::get("Zend_Locale")->getLanguage();

?>
<!DOCTYPE html>
<html lang="<?=$language;?>" >
<?php
$this->template("includes/head.php");
?>
</html>
<?php

$class = "content";

if ($this->portal) {
    $class = "";
}
?>

<body class="<?=$class;?>" lang="<?=$language;?>">
<div id="content">
    <div class="limiter">

        <div class="breadcrumbs">
            <a href="/">home</a>
        </div>

        <?php

        if ($this->portal) {
            echo $this->layout()->content;
        } else {
            if (count($this->placeholder("headline")->getValue()) > 0) {
                echo "<h1>" . $this->placeholder("headline") . "</h1>";
            } else {
                echo "<h1>" . $this->input("Headline") . "</h1>";
            }
            ?>
            <div class="leftcol">
                <?php
                echo $this->layout()->content;

                if ($this->document instanceof Document_Page and $this->document->getProperty("codeview")) {

                    $this->template("tools/codeview.php", array(
                        "codeview" => $this->document
                    ));
                }

                ?>
            </div>
            <?php
            $this->template("includes/rightcol.php");
        }
        ?>
    </div>
    <?php
    $this->template("includes/footer.php");
    ?>
</div>
<?php

$this->template("includes/header.php");

$this->template("includes/loader.php");

?>
</body>
</html>