<?php
	$count = 0;
	while ($count < count($list))
	{
		$orders = $list[$count];
		var_dump($orders);
		require("views/orders_elem.phtml");
		$count++;
	}
?>