<?php
$manager = new ProductsManager($db);
$list = $manager->findByCategory($category);
$count = 0;
while ($count < count($list))// list.length
{
	$product = $list[$count];
	require ('views/product_elem.phtml');
	$count++;
}
?>