<?php

if (isset($_SESSION['email']))
{
	$manager = new UserManager($db);
	$user = $manager->findByEmail($_SESSION['email']);
	require("views/user.phtml");
}

else {
	echo "Erreur: il faut être connecté pour accéder à cette page.";
}


?>