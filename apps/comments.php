<?php

$list = $product->getComments();
$count = 0;
while ($count < count($list))// list.length
{
	$comment = $list[$count];
	require('views/comment.phtml');
	$count++;
}
?>