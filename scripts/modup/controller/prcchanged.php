<?php
$head['title'] = 'Price changed';
$mp = 'prcchanged';


include DIR_CTRL."/actions/products_submits.php";


if(!defined('URI_PART_2')) $order = 'addedon';
else $order = URI_PART_2;

$mpi = $WORKING_URL.'index.php/'.$mp.'/'.$order.'/';
$mpch = $WORKING_URL.'index.php/'.$mp.'/';
$ppi = $WORKING_URL.'index.php/product/';





$prcchanged_array = $products->prcchanged($order);

// print_r($prcchanged_array);

include DIR_VIEW.'/prcchanged.php';

?>