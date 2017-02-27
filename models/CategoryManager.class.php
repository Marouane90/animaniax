<?php
class CategoryManager
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
		$res = mysqli_query($this->db, "SELECT * FROM categories ORDER BY id");
		while ($category = mysqli_fetch_object($res, "Category",[$this->db])) // $article = new article();
		{
			$list[] = $category;
		}
		return $list;
	}
	public function findById($id)
	{
		// /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		$id = intval($id);
		// /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		$res = mysqli_query($this->db, "SELECT * FROM categories WHERE id='".$id."' LIMIT 1");
		$category = mysqli_fetch_object($res, "Category",[$this->db]); // $article = new article();
		return $category;
	}
	// on en a besoin pour la partie login du site internet
	
	// UPDATE
	public function save(Category $category)
	{
		$id = intval($article->getId());
		$name = mysqli_real_escape_string($this->db, $category->getName());
		$description = mysqli_real_escape_string($this->db, $category->getDescription());
		
		$res = mysqli_query($this->db, "UPDATE categories SET name='".$name."', description='".$description."'WHERE id='".$id."' LIMIT 1");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		return $this->findById($id);
	}
	// DELETE
	public function remove(Category $category)
	{
		$id = intval($article->getId());
		$res = mysqli_query($this->db, "DELETE from categories WHERE id='".$id."' LIMIT 1");
		return $category;
	}
	// INSERT
	public function create($name,$description)
	{
		$errors = [];
		$category = new Category($this->db);
		$error = $category->setName($name);// return
		if ($error)
		{
			$errors[] = $error;
			// Si on est dedans, alors y'a eu une erreur
		}
		$error = $category->setDescription($description);
		if ($error)
		{
			$errors[] = $error;
			// Si on est dedans, alors y'a eu une erreur
		}
		
		if (count($errors) != 0)
		{
			throw new Exceptions($errors);
		}
		$name = mysqli_real_escape_string($this->db, $category->getName());
		$description = mysqli_real_escape_string($this->db, $category->getDescription());
		$res = mysqli_query($this->db, "INSERT INTO categories (name,description) VALUES('".$name."','".$description."')");
		$id = mysqli_insert_id($this->db);// last_insert_id
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		$id = mysqli_insert_id($this->db);
		return $this->findById($id);
	}
}
?>