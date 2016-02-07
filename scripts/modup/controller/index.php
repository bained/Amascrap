<?php
$head['title'] = 'Home';
$mp = 'index';

$product_content = array();


if(isset($post['get_amazon_data'])){
	if(!preg_match('@^http@', $post['url']))
		$errors[] = 'Not a URL!';
	if(!preg_match('@//(www.)?amazon.co.uk@', $post['url']))
		$errors[] = 'Link must be http://amazon.co.uk...!';
	if(!$errors)
		$product_content = $amazon->get_amdata($post['url']);
}

if(isset($post['add_product_to_db'])){

	if(!$post['code'] || !$post['name']) $errors[]='Missing data in URL';
	else {
		if(!$post['price']){
			$post['price'] = '0.00';
			$errors[] = 'The price is unknown!';
		}

		$add_product = $products->add($post, $traktor);
		if($add_product) $errors[] = $add_product;
		else $messages[] = "Product successfully added!";
	}
}


// $all_products = $products->getAll();
// print_r($all_products);


include DIR_VIEW.'/index.php';

?>
