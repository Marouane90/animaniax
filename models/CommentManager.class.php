<?php 
class CommentManager
{
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}


	public function findByProducts(Products $product)
	{
		$id_product = intval($product->getId());
		$list = [];
		$res = mysqli_query($this->db, "SELECT * FROM comments WHERE id_product='".$id_product."' ORDER BY date DESC");
		while ($comment = mysqli_fetch_object($res, "Comment", [$this->db]))
		{
			$list[] = $comment;
		}
		return $list;
	}
	public function findById($id) //function obligatoire findBy()
	{
		$id=intval($id); // /!\ hyper important pour la sécurité, ne pas l'oublier /!\
		$res = mysqli_query($this->db, "SELECT * FROM comments WHERE id='".$id."' LIMIT 1");
		$comment = mysqli_fetch_object($res, "Comment", [$this->db]); // $comment = new Comment();
		return $comment;
	}
	// UPDATE
	public function save(Comment $comment) //type hinting:pour forcer la class Comment, avec la propriété $comment
	{
		$id = intval($comment->getId());
		$content = mysqli_real_escape_string($this->db, $comment->getContent());
		$id_author = intval($comment->getAuthor()->getId());
		$id_product = intval($comment->getProduct()->getId());
		$res = mysqli_query($this->db, "UPDATE comments SET content='".$content."', id_author='".$id_author."', id_product='".$id_product."' WHERE id='".$id."' LIMIT 1");
		if (!$res) //$res=false
		{
			throw new Exceptions(["Erreur interne"]);
		}
		return $this->findById($id);
	}
	// DELETE
	public function remove(Comment $comment)
	{
		$id = intval($comment->getId());
		$res = mysqli_query($this->db, "DELETE from comments WHERE id='".$id."' LIMIT 1");
		return $comment;
	}
	// INSERT INTO    dans le même ordre que dans traitementComments.php:$_POST['content'], $_POST['id_article'], $_SESSION['id']
	public function create($content, User $author, Products $product)
	{
		$errors = [];
		$comment = new Comment($this->db);
		$error = $comment->setContent($content);
		if($error)
		{
			$errors[] = $error;
		}
		$error = $comment->setAuthor($author);
		if($error)
		{
			$errors[] = $error;
		}
		$error = $comment->setProduct($product); //return
		if($error)
		{
			$errors[] = $error;
		}
		if(count($errors) != 0)
		{
			throw new Exceptions($errors);
		}
		$content = mysqli_real_escape_string($this->db, $content);
		$id_author = intval($comment->getAuthor()->getId());
		$id_product = intval($comment->getProduct()->getId());
		$res = mysqli_query($this->db, "INSERT INTO comments (content, id_author, id_product) VALUES('".$content."', '".$id_author."', '".$id_product."')");
		// var_dump(mysqli_error($this->db));
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		$id = mysqli_insert_id($this->db);// last_insert_id
		return $this->findById($id);
	}
}
 ?>