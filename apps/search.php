<?php

// $manager = new Categorymanager;
// $category = $manager-> findById();

if(isset($_GET['search'])) 
{   
  $recherche = mysqli_real_escape_string($db, $_GET["search"]);
  $res = mysqli_query($db, "SELECT * FROM categories WHERE name LIKE '%".$recherche."%' OR description LIKE '%".$recherche."%'");
  while($category = mysqli_fetch_object($res, "Category", [$db]))
  {
    require ("views/search_category.phtml");
  }
  $res = mysqli_query($db, "SELECT * FROM products WHERE name LIKE '%".$recherche."%' OR description LIKE '%".$recherche."%'");
  while($product = mysqli_fetch_object($res, "Products", [$db]))
  {
    require ("views/search_product.phtml");
  }
}
?>