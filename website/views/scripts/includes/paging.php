<?php
/**
 * Paging
 *
 * Created by elements.at New Media Solutions GmbH
 * Nikolaus Flamann
 * File: paging.php
 * User: nflamann
 * Date: 26.04.12
 * Time: 12:16
 * @var $this Pimcore_View
 */

if ($this->pageCount > 1) {

    $this->headLink()->appendStylesheet(
        array(
            'href' => '/static/css/paging.css',
            'rel' => 'stylesheet',
            //'media' => 'screen',
            'type' => 'text/css'
        ));


    $pageparam = "page";

    if ($this->pageparam) {
        $pageparam = $this->pageparam;
    }

    if ($this->previous == null) {
        $this->previous = $this->firstPageInRange;
    }
    if ($this->next == null) {
        $this->next = $this->lastPageInRange;
    }


    ?>
<div class="pagingbox">
    <div class="label">
        <?php

        echo $this->translate("Treffer") . " " . $this->firstItemNumber . " - " . $this->lastItemNumber . " ";

        echo $this->translate("von insgesamt") . " " . $this->totalItemCount;

        ?>
    </div>

    <div class="paging">

        <a href="<?= $this->urlprefix . "?" . $pageparam . "=" . $this->firstPageInRange . $this->filterstring; ?>" class="first"></a>
        <a href="<?= $this->urlprefix . "?" . $pageparam . "=" . $this->previous . $this->filterstring; ?>" class="prev left"></a>

        <div class="numbers">
            <?php
            foreach ($this->pagesInRange as $page) {

                $class = "";

                if ($page == $this->current) {
                    $class .= " active";
                }
                if ($page == count($this->pagesInRange)) {
                    $class .=" lastpage";
                }
                ?>
                <a href="<?= $this->urlprefix . "?" . $pageparam . "=" . $page . $this->filterstring; ?>"
                   title="<?=$this->translate("Seite");?> <?= $page; ?>" class="page <?=$class;?>"><?= $page; ?></a>
                <?php

            }
            ?>

        </div>
        <a href="<?= $this->urlprefix . "?" . $pageparam . "=" . $this->next . $this->filterstring; ?>" class="next"></a>
        <a href="<?= $this->urlprefix . "?" . $pageparam . "=" . $this->lastPageInRange . $this->filterstring; ?>" class="last"></a>
    </div>
</div>
<?php
}
