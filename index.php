<?php
/**
 * Created by PhpStorm.
 * User: sharm
 * Date: 3/09/2017
 * Time: 12:06 PM
 */
//includes

include_once 'includes/header.php';

//Variable

$total_rec=16;
$rec_per_page=5;
$pages=ceil($total_rec/$rec_per_page);

//echo "output";

echo '<div id="main_container">
<div id="pagination_wrapper"></div>
</div>';


/*$pagination="<div id='pagination_container'>";
for($i=1;$i<=$pages; $i++){
    $pagination.="<a href='#' class='page_num'>".$i."</a></br>";
}

echo $pagination."</div>";*/

include_once 'includes/footer.php';
