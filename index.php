<?php
$errors = [];
$page = "categories";
// Live test : http://192.168.1.95/partage
$db = mysqli_connect("192.168.1.57","animaniax","animaniax","animaniax");
session_start();
$access = ["errors", "login", "register", "categories", "create_category", "cart", "orders", "user", "create_product", "contact", "search", "products","product"];
if (isset($_GET['page']) && in_array($_GET['page'], $access))
{
    $page = $_GET['page'];
}
function __autoload($classname)// http://php.net/manual/fr/function.autoload.php
{
	require('models/'.$classname.'.class.php');
}
$access_traitement = ["login"=>"users", "register"=>"users", "create_category"=>"category", "cart"=>"orders",
						"user"=>"users", "create_product"=>"Products", "product"=>"orders"]; // comments
if (isset($_GET['page'], $access_traitement[$_GET['page']]))
{
	$traitement = $access_traitement[$_GET['page']];
	require('apps/traitement_'.$traitement.'.php');
}
require('apps/skel.php');
?>