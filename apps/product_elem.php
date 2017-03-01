<?php

if (isset($_GET['id_category']))
{
	$categoryManager = new CategoryManager($db);
	$category = $categoryManager->findById($_GET['id_category']);
	$manager = new ProductsManager($db);
	$list = $manager->findByCategory($category);
	$count = 0;
	

	while ($count < count($list))// list.length
	{
		$product = $list[$count];
		require ('views/product_elem.phtml');
		$count++;
	}
}
else
	echo "taggle";
require('apps/products.php');
?>