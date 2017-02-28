<?php
class Orders
{
	private $id; 
	private $id_users;
	private $status;
	private $price;
	private $date;

	private $users
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function getId()
	{
		return $this->id; 
	}
	public function getUsers()
	{
		$manager = new UserManager($this->db);
		$this->users = $manager->findById($this->id_users);
		return $this->users;
	}
	public function getStatus()
	{
		return $this->status; 
	}
	public function getPrice()
	{
		return $this->price; 
	}
	public function getDate()
	{
		return $this->date; 
	}
	
	// SETTER

	
	public function setUsers(Users $users)
	{
		$this->users = $users;
		$this->id_users = $users->getId();  
	}
	public function setStatus($status)
	{
		if (strlen($status) > 63)
		{
			return "Le statut est invalide";
		} 
		if (strlen($status) < 2)
		{
			return "Le statut est invalide";
		}
		else
		{
			$this->status = $status;
		}
	}
	public function setPrice($price)
	{
		if (strlen($price) < 0)
		{
			return "Le prix ne peut pas être inférieur à 0";
		}
		else
		{
			$this->price = $price;
		}
	}
	public function setDate($date)
	{
		if($date == '')
		{
			return "Date invalide";
		}
		$tab = explode('-', $date);
		if (isset($tab[0], $tab[1], $tab[2]))
		{
			$month = $tab[1];
			$day = $tab[2];
			$year = $tab[0];
			if (checkdate($month, $day, $year) == true)
			{
				$this->date = $date;
			}
			else
			{
				return "La date est invalide.";
			}
		}
	else
	{
		return "Le date est invalide";
	}
}
?>