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
		if (isset($_SESSION['id']))
		{
			require('apps/cart_in.php');
			require('apps/create_comment.php');
		}
		require('apps/comments.php'); 
	}
}
else 
{
	echo "erreur";
}
?>