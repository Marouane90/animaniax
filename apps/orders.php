<?php
if (isset($_SESSION['id']))
{
	$userManager = new UserManager($db);
	$user = $userManager->findById($_SESSION['id']);
	$manager = new OrdersManager($db);
	$orders =  new Orders($db);
	$list = $manager->findByStatus($orders);
	if ($list==0) 
	{
		echo "Vous n'avez pas encore passer de commandes";
	}
	require("views/orders.phtml");
}
else {
	echo "Vous devez être connecté pour afficher l'historique des commandes";
}

?>