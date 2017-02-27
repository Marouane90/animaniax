<?php
$errors = [];
$page = "categories";
$db = mysqli_connect("192.168.1.57","animaniax","animaniax","animaniax");
session_start();// http://php.net/manual/fr/function.session-start.php
$access = ["login", "register", "categories", "category_elem","products", "create_category","cart","orders","users","product","create_comment","create_product","comments"];
if (isset($_GET['page']) && in_array($_GET['page'], $access))
{
    $page = $_GET['page'];
}

require('models/Exceptions.class.php');
require('models/User.class.php');
require('models/Category.class.php');
require('models/Comment.class.php');
require('models/Products.class.php');
require('models/Orders.class.php');

require('models/UserManager.class.php');
require('models/CategoryManager.class.php');
require('models/CommentManager.class.php');
require('models/ProductsManager.class.php');
require('models/OrdersManager.class.php');

require('apps/traitement_category.php');
require('apps/traitement_users.php');
require('apps/traitement_comments.php');
require('apps/traitement_products.php');
require('apps/traitement_orders.php');
require('apps/skel.php');
?>