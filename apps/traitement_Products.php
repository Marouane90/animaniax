<?php
if(isset($_POST['id_category'], $_POST['name'], $_POST['picture'], $_POST['description'], $_POST['price'], $_POST['quantity'],$_SESSION['id']))
{
	$products = new ProductsManager($db);
	$productsManager = new ProductsManager($db);
	$category = $productsManager->findById($_SESSION['id']);
	

try 
	{
		$article = $manager->create($_POST['id_category'], $_POST['name'], $_POST['picture'], $_POST['description'], $_POST['price'], $_POST['quanrtity'],$category);
		if ($article)
		{
			header('Location: index.php?page=products');
			exit;
		}
		else
		{
			$errors[] = "Erreur interne";
		}
   }
   catch (Exception $e)
   {
   		$errors = $e->getErrors();
   }
}