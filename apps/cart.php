<?php 
if (isset($_SESSION['id']))
{
	$userManager = new UserManager($db);
	$user = $userManager->findById($_SESSION['id']);
	$manager = new OrdersManager($db);
	$cart = $manager->findCartByUser($user);
	// if ($cart==0) 
	// {
	// 	echo "Vous n'avez pas encore de panier en cours";
	// }
	require("views/cart.phtml");
}

else {
	echo "Vous devez être connecté pour afficher le panier";
}
?>