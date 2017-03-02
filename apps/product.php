<?php

if (isset($_GET['id']))
{
	$manager = new ProductsManager($db);
	$product = $manager->findById($_GET['id']);
	if ($product == null)
	{
		$errors[]="Cette page n'existe pas";
		require("apps/errors.php");
	}
	else
	{
		require("views/product.phtml");
	}
}
else {
	echo "erreur";
}


if (isset($_SESSION['id']) || isset($_SESSION['admin']))
{

require('apps/create_comment.php');
	
}

require('apps/comments.php'); 







// if(isset($_GET['id']))
// {
// 	$manager = new ProductsManager($db);
// 	$products = $manager->findById($_GET['id']);
// // $id = intval($_GET['id']);
// // $res = mysqli_query($db, "SELECT articles.*,user.login FROM  articles , user WHERE user.id=articles.id_author AND articles.id=".$id);
// // $article = mysqli_fetch_assoc($res);
// 	if ($products)
// 	{	
// 		var_dump($products);
		// require('views/product.phtml');
// 	}
// 	else
// 	{
// 		$errors[] = "L'article n'existe pas";
// 		require('apps/errors.php');	
// 	}	
// }
// else
// {
// 	$errors[] = "L'article n'existe pas";
// 	require('apps/errors.php');	
// }
?>