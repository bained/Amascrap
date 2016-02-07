<?php
$head['title'] = 'Products';
$mp = 'products';


include DIR_CTRL."/actions/products_submits.php";

if(!defined('URI_PART_2')) $order = 'addedon';
else $order = URI_PART_2;

$mpi = $WORKING_URL.'index.php/'.$mp.'/'.$order.'/';
$mpch = $WORKING_URL.'index.php/'.$mp.'/';
$ppi = $WORKING_URL.'index.php/product/';



// Pagination
if(!defined('URI_PART_3')) $p = 1;
else $p = URI_PART_3;

$total_rows = $products->count_all_products();
$paging = $pagination->calculate_pages($total_rows, LIST_PER_PAGE, $p);
$limit = $paging['limit'];

$plinks=$paging['five_links_style'];
// END Pagination



$all_products = $products->getAllLimit($limit, $order);
// print_r($all_products);


include DIR_VIEW.'/products.php';

?>
