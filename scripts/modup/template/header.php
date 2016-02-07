<?php 

if (!isset($head))
{
    $head = array(); 
}
$head['title'] = array_key_exists('title', $head)
    ? $head['title']
    : '';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="<?php echo CSS_PATH; ?>bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="<?php echo CSS_PATH; ?>custom.css" rel="stylesheet" media="screen">
	
	
	<title><?php echo $head['title']; ?></title>

</head>
<body>

<?php include DIR_TMPL.'/topmenu.php'; ?>
