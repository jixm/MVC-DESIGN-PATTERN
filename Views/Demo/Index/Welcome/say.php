<?php
use System\Common\Functions as Y;
$this->display(VIEW.'Index/Public/Header.php',array('nav'=>'this is nav'));
?>
<h1>i m content : <?php echo $name.$action?></h1>

<?php

$this->display(VIEW.'Index/Public/Footer.php');

?>