<?php
class Products
{
	private $id;
	private $id_category; 
	private $name; 
	private $picture; 
	private $description; 
	private $price; 
	private $quantity;

	private $db;
	private $category;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function getId()
	{
		return $this->id;
	} 
	public function getCategory()
	{
		$manager = new CategoryManager($this->db);
		$this->category = $manager->findById($this->id_category);
		return $this->category;
	}
	public function getName()
	{
		return $this->name;
	} 
	public function getPicture()
	{
		return $this->picture;
	} 
	public function getDescription()
	{
		return $this->description;
	} 
	public function gePrice()
	{
		return $this->price;
	} 
	public function getQuantity()
	{
		return $this->quantity;
	} 

	//SETTER

	public function setCategory( Products $category)
	{
		$this->category = $category;
		$this->id_category = $category->getCategory();
	}
	public function setName($name)
	{
		if (strlen($name)<3)
		{
			return "Le nom de la category est trop court (<3)"
		}
		else if (strlen($name)>63)
		{
			return "Le nom de la category est trop long (>63)"
		}
		else
		{
			$this->name = $name;
		}
	}
	public function setPicture($picture)
	{
		if (strlen($picture)<3)
		{
			return "L'url de l'image est trop court (<3)"
		}
		if (strlen($picture)>511)
		{
			return "L'url de l'image est trop long (>511)"
		}
	}
	public function setDescription($description)
	{
		if (strlen($description)<3)
		{
			return "L'url de l'image est trop court (<3)"
		}
		if (strlen($description)>1023)
		{
			return "L'url de l'image est trop long (>1023)"
		}
	}
	public function setPrice($price)
	{
		if ($price <= 0)
		{
			return "Le prix ne peut pas etre inférieur à 0"
		}
		if ($price => 10 000)
		{
			return "Le prix est trop elevé"
		}
	}
	public function setQuantity($quantity)
	{
		if ($quantity) <= 0)
		{
			return "Les quantités ne peuvent pas être négatives"
		}
	}

}