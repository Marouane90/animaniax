<?php
if (isset($_POST['action']))
{
	$action = $_POST['action'];
	if ($action == "add")
	{
		if (isset($_SESSION['id'], $_POST['id_product'], $_POST['quantity']))
		{
			$manager = new OrdersManager($db);
			$usersManager = new UserManager($db);
			$productManager = new ProductsManager($db);
			$product = $productManager->findById($_POST['id_product']);
			$user = $usersManager->findById($_SESSION['id']);
			$quantity =intval($_POST['quantity']);
			if ($quantity <= 0)
			{
				$errors[] = 'Sold out';
			}
			else
			{
				$cart = $user->getCart();
				try
				{
					if (!$cart)
					{
						$cart = $manager->create($user);
					}
			
					if($product->getQuantity()>=$quantity)
					{
						$count=0;
						while($count < $quantity)
						{
						$cart->addProduct($product);
						$count++;
						}
					}
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
	if ($action == "delete")
	{
		// Etape 1
		if (isset($_POST['id_product'],$_SESSION['id']))
		{
			// Etape 2
			$manager = new OrdersManager($db);
			$productsManager = new ProductsManager($db);
			$userManager = new UserManager($db);
			$product = $productsManager->findById($_POST['id_product']);
			$users = $usersManager->findById($_SESSION['id']);
			$cart = $user->getCart();
			try
			{
				$cart->remove($product);
				$manager->save($cart);
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
		if (isset($_SESSION['id']))
		{
			// Etape 2
			$manager = new OrdersManager($db);
			$userManager = new UserManager($db);
			$user = $userManager->findById($_SESSION['id']);
			
			try
			{
				$cart = $user->getCart();
				$cart->setStatus("termine");
				$manager->save($cart);
				header('Location: index.php?page=orders');
				exit;
			}
			catch (Exceptions $e)
			{
				$errors = $e->getErrors();
			}
		}
	}
	
}
?>