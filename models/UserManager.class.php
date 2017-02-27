<?php 
class UserManager
{
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}
	// SELECT
	public function findAll()
	{
		$list = [];
		$res = mysqli_query($this->db, "SELECT * FROM users ORDER BY login");
		while ($user = mysqli_fetch_object($res, "User")) // $user = new User();
		{
			$list[] = $user;
		}
		return $list;
	}
	public function findById($id) //function obligatoire findBy()
	{
		$id=intval($id); // /!\ hyper important pour la sécurité, ne pas l'oublier /!\
		$res = mysqli_query($this->db, "SELECT * FROM users WHERE id='".$id."' LIMIT 1");
		$user = mysqli_fetch_object($res, "User"); // $user = new User();
		return $user;
	}
	
	public function findByEmail($email) 
	{
		$email=mysqli_real_escape_string($this->db, $email); // /!\ hyper important pour la sécurité, ne pas l'oublier /!\
		$res = mysqli_query($this->db, "SELECT * FROM users WHERE email='".$email."' LIMIT 1");
		$user = mysqli_fetch_object($res, "User"); // $user = new User();
		return $user;
	}
	// UPDATE
	public function save(User $user) //type hinting:pour forcer la class User, avec la propriété $user
	{
		$id = intval($user->getId());
		$email = mysqli_real_escape_string($this->db, $user->getEmail());
		$password = mysqli_real_escape_string($this->db, $user->getPassword());
		$name = mysqli_real_escape_string($this->db, $user->getName());
		$address = mysqli_real_escape_string($this->db, $user->getAddress());
		$city = mysqli_real_escape_string($this->db, $user->getCity());
		$birthdate = mysqli_real_escape_string($this->db, $user->getBirthdate());
		$admin = mysqli_real_escape_string($this->db, $user->getAdmin());
		$res = mysqli_query($this->db, "UPDATE users SET email='".$email."', password='".$password."', name='".$name."', address='".$address."', city='".$city."', birthdate='".$birthdate."', admin='".$admin."' WHERE id='".$id."' LIMIT 1");
		if (!$res) //$res=false
		{
			throw new Exceptions(["Erreur interne"]);
		}
		return $this->findById($id);
	}
	// DELETE
	public function remove(User $user)
	{
		$id = intval($user->getId());
		$res = mysqli_query($this->db, "DELETE from users WHERE id='".$id."' LIMIT 1");
		return $user;
	}
	// INSERT INTO
	public function create($email, $password1, $password2, $name, $address, $city, $birthdate)
	{
		$errors = [];
		$user = new User();
		$error = $user->setEmail($email);
		if($error)
		{
			$errors[] = $error;
		}
		$error = $user->setPassword($password1);
		if($error)
		{
			$errors[] = $error;
		}
		$error = $user->setName($name);
		if($error)
		{
			$errors[] = $error;
		}
		$error = $user->setAddress($address);
		if($error)
		{
			$errors[] = $error;
		}
		$error = $user->setCity($city);
		if($error)
		{
			$errors[] = $error;
		}
		$error = $user->setBirthdate($birthdate);
		if($error)
		{
			$errors[] = $error;
		}
		if(count($errors) != 0)
		{
			throw new Exceptions($errors);
		}
		$email = mysqli_real_escape_string($this->db, $email);
		$hash = password_hash($password1, PASSWORD_BCRYPT, ["cost"=>11]);
		$name = mysqli_real_escape_string($this->db, $name);
		$address = mysqli_real_escape_string($this->db, $address);
		$city = mysqli_real_escape_string($this->db, $city);
		$birthdate = mysqli_real_escape_string($this->db, $birthdate);
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