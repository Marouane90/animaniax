<?php
if (isset($_GET['id_category']))
{

	$categoryManager = new CategoryManager($db);
	$category = $categoryManager->findById($_GET['id_category']);
	$manager = new ProductsManager($db);
	$list = $manager->findByCategory($category);
}
	require('views/products.phtml');
	
else{
	echo "erreur";
}


?>
