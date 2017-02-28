<?php
if (isset($_SESSION['id']))
{
	$userManager = new UserManager($db);
	$user = $userManager->findById($_SESSION['id']);
	$manager = new OrdersManager($db);
	$list = $manager->findByUsers($user);
	var_dump($list);
	require("views/orders.phtml");
}

else {
	echo "Vous devez être connecté pour afficher l'historique des commandes";
}

?>