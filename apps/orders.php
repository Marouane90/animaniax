<?php 
if (isset($_GET['id']))
{
	$manager = new OrdersManager($db);
	$order = $manager->findById($_GET['id']);
	require("views/orders.phtml");
}

else {
	echo "Pas de commandes en cours!";
}

?>