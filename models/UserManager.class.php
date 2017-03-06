<?php 
class UserManager
{
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}
	
	public function findAll()
	{
		$list = [];
		$res = mysqli_query($this->db, "SELECT * FROM users ORDER BY login");
		while ($user = mysqli_fetch_object($res, "User", [$this->db])) 
		{
			$list[] = $user;
		}
		return $list;
	}
	public function findById($id)
	{
		$id=intval($id); 
		$res = mysqli_query($this->db, "SELECT * FROM users WHERE id='".$id."' LIMIT 1");
		$user = mysqli_fetch_object($res, "User", [$this->db]); 
		return $user;
	}
	
	public function findByEmail($email)
	{
		$email=mysqli_real_escape_string($this->db, $email); 
		$res = mysqli_query($this->db, "SELECT * FROM users WHERE email='".$email."' LIMIT 1");
		$user = mysqli_fetch_object($res, "User", [$this->db]); 
		return $user;
	}
	
	public function save(User $user)
	{
		$id = intval($user->getId());
		$email = mysqli_real_escape_string($this->db, $user->getEmail());
		$password = mysqli_real_escape_string($this->db, $user->getPassword());
		$name = mysqli_real_escape_string($this->db, $user->getName());
		$address = mysqli_real_escape_string($this->db, $user->getAddress());
		$city = mysqli_real_escape_string($this->db, $user->getCity());
		$birthdate = mysqli_real_escape_string($this->db, $user->getBirthdate());
		$admin = (boolean)$user->isAdmin();
		$res = mysqli_query($this->db, "UPDATE users SET email='".$email."', password='".$password."', name='".$name."', address='".$address."', city='".$city."', birthdate='".$birthdate."', admin='".$admin."' WHERE id='".$id."' LIMIT 1");
		if (!$res) 
		{
			throw new Exceptions(["Erreur interne"]);
		}
		return $this->findById($id);
	}
	
	public function remove(User $user)
	{
		$id = intval($user->getId());
		$res = mysqli_query($this->db, "DELETE from users WHERE id='".$id."' LIMIT 1");
		return $user;
	}
	
	public function create($email, $password1, $password2, $name, $address, $city, $birthdate)
	{
		$errors = [];
		$user = new User($this->db);
		if (($error = $user->setEmail($_POST['email'])))
			$errors[] = $error;
		if (($error = $user->setName($_POST['name'])))
			$errors[] = $error;
		if (($error = $user->setAddress($_POST['address'])))
			$errors[] = $error;
		if (($error = $user->setCity($_POST['city'])))
			$errors[] = $error;
		if (($error = $user->setBirthdate($birthdate)))
			$errors[] = $error;
		if (($error = $user->initPassword($_POST['password1'], $_POST['password2'])))
			$errors[] = $error;
		if(count($errors) != 0)
		{
			throw new Exceptions($errors);
		}
		$email = mysqli_real_escape_string($this->db, $user->getEmail());
		$hash = mysqli_real_escape_string($this->db, $user->getPassword());
		$name = mysqli_real_escape_string($this->db, $user->getName());
		$address = mysqli_real_escape_string($this->db, $user->getAddress());
		// $city = mysqli_real_escape_string($this->db, $city);
		$city = mysqli_real_escape_string($this->db, $user->getCity());
		$birthdate = mysqli_real_escape_string($this->db, $user->getBirthdate());
		$res = mysqli_query($this->db, "INSERT INTO users (email, password, name, address, city, birthdate) VALUES('".$email."', '".$hash."', '".$name."', '".$address."', '".$city."', '".$birthdate."')");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		$id = mysqli_insert_id($this->db);
		return $this->findById($id);
	}
}
 ?>