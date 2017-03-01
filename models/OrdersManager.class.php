<?php
class OrdersManager
{	

	private $db;
	public function __construct($db)
	{
		$this->db=$db;
	}
	// SELECT
	public function findAll()
	{	
		$list = [];
		$res = mysqli_query($this->db, "SELECT * FROM orders ORDER BY date");
		while ($orders = mysqli_fetch_object($res, "Orders", [$this->db]))
		{
			$list[] = $orders;
		}
		return $list;
	}
	public function findById($id)
	{
		$id = intval($id);
		$res = mysqli_query($this->db, "SELECT * FROM orders WHERE id='".$id."'");
		$orders = mysqli_fetch_object($res, "Orders", [$this->db]);
		return $orders;
	}
	public function findByUsers(User $user)
	{
		$id_users = intval($user->getId());
		$list = [];

		$res = mysqli_query($this->db, "SELECT * FROM orders WHERE id_users='".$id_users."'");
		while($order = mysqli_fetch_object($res, "Orders", [$this->db]))
		{
			$list[] = $order;
		}
		return $list;
	}
	public function findCartByUser(User $user)
	{
		$id_users = intval($user->getId());
		
		$res = mysqli_query($this->db, "SELECT * FROM orders WHERE id_users='".$id_users."' AND status='panier' ORDER BY date LIMIT 1");
		$cart = mysqli_fetch_object($res, "Orders", [$this->db]);
		
		return $cart;
	}
	// UPDATE
	public function save(Orders $orders)
	{
		$id = intval($orders->getId());
		$products = $orders->getProducts();
		mysqli_query($this->db, "DELETE FROM link_orders_products WHERE id_orders='".$id."'");
		$count = 0;
		while ($count < count($products))
		{
			mysqli_query($this->db, "INSERT INTO link_orders_products (id_orders, id_products) VALUES('".$id."', '".$products[$count]->getId()."')");
			$count++;
		}
		$id_users = intval($orders->getUser()->getId());
		$status = mysqli_real_escape_string($this->db, $orders->getStatus());
		$price = floatval($orders->getPrice());
		$date = mysqli_real_escape_string($this->db, $orders->getDate());
		
		mysqli_query($this->db, "UPDATE orders SET id_users='".$id_users."', status='".$status."', price='".$price."', date='".$date."', WHERE id='".$id."'");
		return $this->findById($id);
	}
	// DELETE
	public function remove(Orders $orders)
	{
		$id = intval($orders->getId());
		mysqli_query($this->db, "DELETE from orders WHERE id='".$id."' LIMIT 1");
		return $orders;	
	}
	// INSERT
	public function create(User $user)
	{
		$errors = [];
		$orders = new Orders($this->db);

		$error = $orders->setUser($user);
		if ($error)
		{
			$errors[] = $error;
		}
		
		if (count($errors) != 0)
		{
			throw new Exceptions($errors);
		}	

		$id_users = intval($orders->getUser()->getId());
		$res = mysqli_query($this->db, "INSERT INTO orders (id_users) VALUES('".$id_users."')");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}	
		$id = mysqli_insert_id($this->db);
		return $this->findById($id);
	}
}

?>