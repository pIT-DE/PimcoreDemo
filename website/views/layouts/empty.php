<?php
/**
 * Created by elements.at New Media Solutions GmbH
 * Nikolaus Flamann
 * File: empty.php
 * User: nflamann
 * Date: 16.07.12
 * Time: 22:20
 * @var $this Pimcore_View
 */
?>
<!DOCTYPE html>
<html>
    <?php
    $this->template("includes/head.php");
    ?>

<body data-lang="<?=$this->language;?>">


<?php

echo  $this->layout()->content;


$this->template("includes/loader.php");
?>

</body>
</html>
