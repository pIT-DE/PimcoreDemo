<?php
/**
 * Created by elements.at New Media Solutions GmbH
 * Nikolaus Flamann
 * File: list.php
 * User: nflamann
 * Date: 04.07.12
 * Time: 18:10
 * @var $this Pimcore_View
 * @var $news Object_News
 * @var $pageing string
 */

$this->headLink()->appendStylesheet(
    array(
        'href' => '/static/css/news.css',
        'rel' => 'stylesheet',
        //'media' => 'screen',
        'type' => 'text/css'
    ));

$this->layout()->setLayout("default");

$this->template("content/starter/block.php");

$pageing = $this->paginationControl($this->paginator, 'Elastic', 'includes/paging.php',
    array(
        'urlprefix' => $this->document->getFullPath() . '/',
        'filterstring' => $this->filterstring));

echo $pageing;



?>
<div class="newsitems">

    <?php
    foreach ($this->paginator as $news) {
        ?>
        <div class="item">
            <?php
            if ($news->getImage() instanceof Asset_Image) {


                ?>
                <img src="<?=$news->getImage()->getThumbnail("objectNews");?>" alt="<?=$news->getName()?>"/>
                <?php
            }
            ?>

            <div class="bar">
                <div class="title"><?=$news->getName()?></div>
                <?php
                if ($news->getDate() instanceof Zend_Date) {
                    ?>
                    <div class="date">
                        <?=$news->getDate()->get(Zend_Date::DATE_FULL);?>
                    </div>
                    <?php
                }
                ?>
                <div class="desc">
                    <?=$news->getDate();?>
                </div>
            </div>
            <a href="#" class="isnone"></a>

        </div>
        <?php
    }
    ?>

</div>

