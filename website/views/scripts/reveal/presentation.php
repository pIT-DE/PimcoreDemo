<?php
/**
 * Created by elements.at New Media Solutions GmbH
 * Nikolaus Flamann
 * File: demo.php
 * User: nflamann
 * Date: 16.07.12
 * Time: 22:20
 *
 * @var $this Pimcore_View
 */

$isSub = false;

if ($this->isSub) {
    $isSub = true;
}

$this->layout()->setLayout('empty');


if (!$isSub) {
    ?>

<div class="reveal">

    <!-- Used to fade in a background when a specific slide state is reached -->
    <div class="state-background"></div>

    <!-- Any section element inside of this container is displayed as a slide -->
    <div class="slides">

        <?php
}
while ($this->block("section")->loop()) {

    ?>
    <section>
        <?php
        if (!$this->editmode and !$this->href("addVertical")->isEmpty()) {
            ?>
                    <section>
                    <?php
        }
        $this->template("training/includes/section.php");
        if ($this->editmode) {
            echo "Gehe in die \"Tiefe\"";
            echo $this->href("addVertical");
        }
        if (!$this->editmode and !$this->href("addVertical")->isEmpty()) {

            ?>
                    </section>
                    <?php

            $sub = $this->href("addVertical")->getElement();

            echo $this->inc($sub, array("isSub" => true));
        }


        ?>
    </section>
    <?php
}
if (!$isSub) {
    ?>
    </div>

    <aside class="controls">
        <a class="left" href="#">&#x25C4;</a>
        <a class="right" href="#">&#x25BA;</a>
        <a class="up" href="#">&#x25B2;</a>
        <a class="down" href="#">&#x25BC;</a>
    </aside>

    <div class="progress"><span></span></div>

</div>

<?php
}

