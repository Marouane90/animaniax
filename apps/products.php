<?php
if (isset($_GET['id_category']))
{
	$categoryManager = new CategoryManager($db);
	$category = $categoryManager->findById($_GET['id_category']);
	if ($category)
	{
		require('views/products.phtml');
	}
	else
	{
		$errors[] = "YOLO";
		require('views/errors.phtml');
	}
}
else
{
	echo "erreur";
}
?>
