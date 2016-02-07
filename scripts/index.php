<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'init.php';


if ($ctrl = Router::controller()) 
{
    include $ctrl;
}
else 
{
    header('HTTP/1.1 404 Not Found');
    echo "Page not found!";
}

//}}}

?>
