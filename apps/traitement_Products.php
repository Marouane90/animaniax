<?php
if(isset($_POST['id_category'], $_POST['name'], $_POST['picture'], $_POST['description'], $_POST['price'], $_POST['quantity'],$_SESSION['id']))
{
	$manager = new ProductsManager($db);
	$categoryManager = new CategoryManager($db);
	$category = $categoryManager->findById($_POST['id_category']);
	

try 
	{
		$article = $manager->create($category, $_POST['name'], $_POST['picture'], $_POST['description'], $_POST['price'], $_POST['quanrtity']);
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