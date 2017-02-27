<?php
class Orders
{
	private $id; 
	private $id_users;
	private $date;
	private $status;
	private $price;

	private $id_users;
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
		return $this->id_users; 
	}
	public function getDate()
	{
		return $this->date; 
	}
	public function getStatus()
	{
		return $this->status; 
	}
	public function getPrice()
	{
		return $this->price; 
	}
	
	// SETTER

	
	public function setUsers(Users $users)
	{
		$this->users = $users;
		$this->id_author = $users->getId();  
	}
	public function setDate($date)
	{
		$tab = explode('-', $date);
		$month = $tab[1];
		$day = $tab[2];
		$year = $tab[0];

		if (checkdate($month, $day, $year) == true)
		{
			$this->date = $date;
		} 
	}
	
	public function setStatus($status)
	{
		if (strlen($status) < 63 && strlen($status) < 2)
		{
			$this->status = $status;
		} 
	}
	public function setPrice($price)
	{
		if ($price <= 0)
		{
			return "Le prix ne peut pas être inférieur à 0"
		}
		if ($price >= 10000 )
		{
			return "Le prix ne peut pas être supérieur à 10000"
		}
	}
}
?>