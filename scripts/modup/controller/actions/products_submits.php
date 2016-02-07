<?php

// ============= SUBMITS =================
if(isset($post['submit_product_update']) && isset($post['code']) && $post['code']){
	$get_price = $amazon->update_price($post['code']);
	if(!$get_price){
		$errors[] = 'ERROR: Can not get latest price!';
		// break;
	} else {
		$update_product = $products->update_product_price($post['code'], $get_price, $traktor);
		if($update_product) $errors[] = 'ERROR: Can not add new price to DB!';
		else $messages[] = 'Produc successfully updated!';
	}
}
 // Update All prices
if(isset($post['submit_update_all_products']) || isset($post['submit_update_all_prc_products']) || isset($post['submit_product_full_update'])){
	if(isset($post['submit_update_all_products']))
		$all_codes = $products->get_all_codes();
	if(isset($post['submit_update_all_prc_products']))
		$all_codes = $products->get_all_prc_codes();
	if(isset($post['submit_product_full_update']))
		$all_codes = array($post['code']);


	
	if($all_codes) {
		$all_prices = $amazon->get_all_prices($all_codes);
		// print_r($all_prices);
		$allupdatedcodes = array();

		foreach ($all_prices as $key => $value) {
			if(!$products->update_product_price($key, $value, $traktor)){
				$allupdatedcodes[] = $key;
			} else {
				$errors[] = 'ERROR: Code '.$key."<br />";
			}
		}

		if($allupdatedcodes) $messages[] = "Products with codes: <br>".implode(", ", $allupdatedcodes)."<br> successfully updated!";
	}
}

// Make Latest Price --> First Price
if(isset($post['submit_product_ch_first_price']) && isset($post['first_price']) && $post['first_price'] && isset($post['code']) && $post['code']){
	if(!$products->ch_first_price($post['code'], $post['first_price'])){
		$messages[] = "First price now is last known price!";
	} else {
		$errors[] = 'ERROR: Can not update First price!';
	}
}


// Full Update Products
if(isset($post['submit_products_fullupdate'])){
	$all_codes = $products->get_all_codes();
	
	if($all_codes) {
		foreach ($all_codes as $key) {
			$full_update_product = $amazon->productFullUpdate($key);
			if($full_update_product){
				$fup_toDB = $products->productFullUpdate($full_update_product, $key, $traktor);
				if(!$fup_toDB){
					$keys[] = $key;
				} else {
					$errors[] = $fup_toDB;
				}
			} else {
				$errors[] = "Can't get data for code ".short_link($key)."!";
			}
		}

		if(!$errors){
			$messages[] = "All products successfully updated!";
		}
	}
	unset($all_codes, $key, $product, $fup_toDB, $full_update_product, $keys);
}




// Delete product
if(isset($post['submit_product_delete']) && isset($post['code']) && $post['code']){
	$delete_product = $products->delete_product($post['code'], $traktor);
		if($delete_product) $errors[] = 'ERROR: '.$delete_product;
		else $messages[] = 'Produc successfully deleted!';
}
// ============= END SUBMITS =================

?>