<?php

/* SUBMITS
================================= */
// print_r($post);

if(isset($post['submit_db_file']) ){

	if(isset($files) && $files){
		$tmp_name = $files["db_file"]["tmp_name"];
		$db_file = "DB_DIR".gmtimestamp(timestamp())."_db.sqlite";
		$dest_file = constant("DB_DIR").gmtimestamp(timestamp())."_db.sqlite";

		if(move_uploaded_file($tmp_name, $dest_file)){
			$settings_array = $settings->allSettings();
			$settings_array['database_file'] = $db_file;
			$settings->write_php_ini($settings_array);
		}
	}
}

if(isset($post['submit_restoreDefaultDB']) ){

	$settings->restoreDefaultDB();
}

if(isset($post['submit_productsPerPage'])){
	if(isset($post['productsPerPage']) && $post['productsPerPage']){
		$productsPerPage = (int) $post['productsPerPage'];
		if($productsPerPage < 2) $productsPerPage = 2;
		$changeppp = $settings->productsPerPage($productsPerPage);
	}
}


/*  ================================  */

$head['title'] = 'Settings';
$mp = 'settings';


$all_settings = $settings->allSettings();
// print_r($all_settings);


include DIR_VIEW.'/settings.php';

?>