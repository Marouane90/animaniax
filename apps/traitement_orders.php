<?php
if (isset($_POST['action']))
{
	$action = $_POST['action'];
	if ($action == "create")
	{
		// Etape 1
		if (isset($_SESSION['id']))
		{
			// Etape 2
			$manager = new OrdersManager($db);
			$usersManager = new UsersManager($db);
			$users = $usersManager->findById($_SESSION['id']);
			try
			{
				$orders = $manager->create($users);
				if ($orders)
				{
					header('Location: index.php?page=orders');
					exit;
				}
				else
				{
					$errors[] = "Erreur interne";
				}	
			}
			catch (Exceptions $e)
			{
				$errors = $e->getErrors();
			}
		}
	}
	if ($action == "modify")
	{
		// Etape 1
		if (isset($_POST['id_orders'],$_POST['id_products']))
		{
			// Etape 2
			$manager = new OrdersManager($db);
			$productsManager = new ProductsManager($db);
			$usersManager = new UsersManager($db);
			$users = $usersManager->findById($_SESSION['id']);
			try
			{
				$orders = $manager->modify($users);
				if ($orders)
				{
					header('Location: index.php?page=orders');
					exit;
				}
				else
				{
					$errors[] = "Erreur interne";
				}	
			}
			catch (Exceptions $e)
			{
				$errors = $e->getErrors();
			}
		}
	}
}
?>