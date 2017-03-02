<?php
$manager = new ProductsManager($db);
$userManager = new UserManager($db);
$user = $userManager->findById($_SESSION['id']);
$cart = $user->getCart();
$list = $manager->findByCategory($category);

$count = 0;
while ($count < count($list))// list.length
{
	$product = $list[$count];
	require ('views/product_elem.phtml');
	$count++;
}
?>