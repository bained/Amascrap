<?php
$head['title'] = 'Product';
$mp = 'product';


include DIR_CTRL."/actions/products_submits.php";

$mpi = $WORKING_URL.'index.php/'.$mp.'/';


if(!defined('URI_PART_2')) $errors[] = 'ERROR: Not set product id!';
else $p = URI_PART_2;

$product = $products->get($p);


$all_tracked_prices = $traktor->getallpoints($p);
$formatdatearray = $traktor->formatdatearray($all_tracked_prices);
// print_r($formatdatearray);

include DIR_VIEW.'/product.php';

?>
