<?php
if (isset($_POST['action']))
{
	$action = $_POST['action'];
	if ($action == "add")
	{
		if (isset($_SESSION['id'], $_POST['id_product']))// $_POST['quantity']
		{
			$manager = new OrdersManager($db);
			$usersManager = new UserManager($db);
			$productManager = new ProductsManager($db);
			$product = $productManager->findById($_POST['id_product']);
			$user = $usersManager->findById($_SESSION['id']);
			$cart = $user->getCart();
			try
			{
				if (!$cart)
				{
					$cart = $manager->create($user);
				}
				$cart->addProduct($product);
				$manager->save($cart);
				header('Location: index.php?page=cart');
				exit;
			}
			catch (Exceptions $e)
			{
				$errors = $e->getErrors();
			}
		}
	}
	if ($action == "create")
	{
		// Etape 1
		if (isset($_SESSION['id']))
		{
			// Etape 2
			$manager = new OrdersManager($db);
			$usersManager = new UserManager($db);
			$users = $usersManager->findById($_SESSION['id']);
			try
			{
				$orders = $manager->create($users);
				if ($orders)
				{
					header('Location: index.php?page=cart');
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
					header('Location: index.php?page=cart');
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

	if ($action == "v_order")
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
					header('Location: index.php?page=cart');
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