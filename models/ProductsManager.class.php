<?php
	class ProductsManager
	{
		private $db;

		public function __construct($db)
		{
			$this->db=$db;
		}

		public function findByCategory(Category $category)
		{
			$id_category = intval($category->getId());
			$list = [];
			$res = mysqli_query($this->db, "SELECT * FROM products WHERE id_category='".$id_category."' ORDER BY name");
			while($products = mysqli_fetch_object($res, "Products", [$this->db]))

			//$user = new User();
			
			{
				$list[] = $products;
			}
			return $list;
		}
		public function findById($id)
		{
			$id = intval($id);
	
			$res = mysqli_query($this->db, "SELECT * FROM products WHERE id='".$id."'");
			$products = mysqli_fetch_object($res, "Products", [$this->db]); 

			// $user = new User();

			return $products;
		}

		public function save(Products $products)
		{
			$id = intval($products->getId());
			$id_category = intval($products->getCategory()->getId());
			$name = mysqli_real_escape_string($this->db, $products->getName());
			$picture = mysqli_real_escape_string($this->db, $products->getPicture());
			$description = mysqli_real_escape_string($this->db, $products->getDescription());
			$price = floatval($products->getPrice());
			$quantity = intval($product->getQuantity());
			$res = mysqli_query($this->db, "UPDATE products SET id_category='".$id_category."', name='".$name."', picture='".$picture."', description= '".$description."', price='".$price."', quantity= '".$quantity."' WHERE id='".$id."' LIMIT 1");

		}
			public function remove(Products $products)
		{
				$id = intval($products->getId());
			mysqli_query($this->db, "DELETE from products WHERE id='".$id."' LIMIT 1");
			return $products;
		}
		public function create(Category $category, $name, $picture, $description, $price, $quantity)
		{
			$errors = [];
			$products = new Products($this->db);
			$error = $products->setCategory($category);
			if($error)
			{
				$errors[] = $error;
				// Si on est dedans, alors y'a eu une erreur
			}
			$error = $products->setName($name);// throw
			if($error)
			{
				$errors[] = $error;
				// Si on est dedans, alors y'a eu une erreur
			}
			$error = $products->setPicture($picture);
			if($error)
			{
				$errors[] = $error;
				// Si on est dedans, alors y'a eu une erreur
			}
			$error = $products->setDescription($description);
			if($error)
			{
				$errors[] = $error;
				// Si on est dedans, alors y'a eu une erreur
			}
			$error = $products->setPrice($price);
			if($error)
			{
				$errors[] = $error;
				// Si on est dedans, alors y'a eu une erreur
			}
			$error = $products->setQuantity($quantity);
			if($error)
			{
				$errors[] = $error;
				// Si on est dedans, alors y'a eu une erreur
			}
			if (count($errors) != 0)
			{
				throw new Exceptions($errors);
			}

			$id_category= intval($products->getCategory()->getId());
			$name = mysqli_real_escape_string($this->db, $products->getName());
			$picture = mysqli_real_escape_string($this->db, $products->getPicture());
			$description = mysqli_real_escape_string($this->db, $products->getDescription());
			$price = floatval($products->getPrice());
			$quantity = intval($products->getQuantity());
			$res = mysqli_query($this->db, "INSERT INTO products (id_category, name, picture, description, price, quantity) VALUES('".$id_category."', '".$name."', '".$picture."', '".$description."', '".$price."', '".$quantity."')");
			$id = mysqli_insert_id($this->db);// last_insert_id
			return $this->findById($id);
		}
	}
?>