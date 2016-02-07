<?php
set_time_limit(0);
ob_start('ob_gzhandler');
date_default_timezone_set("Europe/Sofia");





//{{{ defining constants
define('DIR_WEB', dirname(__FILE__));
define('DIR_MODUP', dirname(__FILE__).'/modup');
define('DIR_SYS', DIR_MODUP.'/system');
define('DIR_CTRL', DIR_MODUP.'/controller');
define('DIR_TMPL', DIR_MODUP.'/template');
define('DIR_VIEW', DIR_MODUP.'/view');
define('DEFAULT_DB', 'DB_DIR'.'data.sqlite');
define('DB_DIR', DIR_MODUP.'/system/db/');

// NED //
$WORKING_URL = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/';

define('THEME', 'default');
define('CSS_PATH', $WORKING_URL.'modup/template/themes/'.THEME.'/css/');
define('JS_PATH', $WORKING_URL.'modup/template/themes/'.THEME.'/js/');

// Pagination
// define('LIST_PER_PAGE', 2);
define('DIR_SM_IMG', DIR_MODUP.'/system/db/pictures/');
define('DIR_SHOW_SM_IMG', $WORKING_URL.'modup/system/db/pictures/');

$post = array();
if(isset($_POST) && $_POST){
	if(isset($_FILES) && $_FILES){
		$files = $_FILES;
		unset($_FILES);
		// print_r($files);
	} 
	// print_r($_POST);
	// echo basename($_FILES["db_file"]["name"]);
	// print_r($_FILES);
	$post = $_POST;
	unset($_POST);
}

// print_r($post);

// .NED //

//}}}
//{{{ disecting the URI
$ru = &$_SERVER['REQUEST_URI'];
// $ru = $_SERVER['REQUEST_URI'];
// print_r($ru);
$qmp = strpos($ru, '?');
list($path, $params) = $qmp === FALSE
    ? array($ru, NULL)
    : array(substr($ru, 0, $qmp), substr($ru, $qmp + 1));
$parts = explode('/', $path);
$i = 0;
foreach ($parts as $part)
{
    if (strlen($part) && $part !== '..' && $part !== '.')
    {
        define('URI_PART_'.$i++, $part);
    }
}
define('URI_PARAM', isset($params) ? '' : $params);
define('URI_PARTS', $i);
define('URI_PATH', $path);
define('URI_REQUEST', $_SERVER['REQUEST_URI']);

//}}}

//{{{ Database AND Settings
include DIR_SYS.'/classes/settings.php';
$settings = new Settings();
$fdb = ($settings->allSettings('database_file'));
$fdb = realpath(preg_replace('@^DB_DIR@', DB_DIR, $fdb));

define('LIST_PER_PAGE', $settings->allSettings('productsPerPage'));

$db = new PDO('sqlite:'.$fdb);
// $db = new PDO('sqlite:'.DIR_MODUP.'/system/db/data.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//}}}

//{{{ routing and other init
session_start();
include DIR_SYS.'/router.php';
include DIR_SYS.'/config.routes.php';
include DIR_SYS.'/classes/amazon.php';
include DIR_SYS.'/classes/products.php';
include DIR_SYS.'/classes/traktor.php';
include DIR_SYS.'/classes/pagination.php';
include DIR_SYS.'/functions.php';

$amazon = new Amazon($db);
$traktor = new Traktor($db);
$products = new Products($db);
$pagination = new pagination();







$errors = array();
$messages = array();

$mp = '';

?>