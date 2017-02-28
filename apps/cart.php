<?php 
if (isset($_SESSION['id']))
{
	$userManager = new UserManager($db);
	$user = $userManager->findById($_SESSION['id']);
	$manager = new OrdersManager($db);
	$cart = $manager->findCartByUsers($user);
	var_dump($cart);
	require("views/cart.phtml");
}

else {
	echo "Vous devez être connecté pour afficher le panier";
}
?>