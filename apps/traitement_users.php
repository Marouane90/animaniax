<?php 

// Etape 0 : pendant le développement on laisse le var_dump
var_dump($_POST);

if (isset($_GET["page"]) && $_GET["page"] == "logout")
{
	session_destroy();
	header("Location: index.php");
	exit;
}
if (isset($_POST["action"]))
{
	$action = $_POST["action"];
	if ($action == "register")
	{
		// Etape 1 : Vérification de la présence des variables "name" dans $_POST (ou $_GET)
		if(isset($_POST["email"], $_POST["password1"], $_POST["password2"], $_POST["name"], $_POST["address"], $_POST["city"], $_POST["birthdate"])) //correspond aux name dans l'input de phtml
		{
			// Etape 2 : Validation des données
			$manager = new UserManager($db);
			try
			{
				$user = $manager->create($_POST['email'], $_POST['password1'], $_POST['password2'], $_POST['name'], $_POST["address"], $_POST["city"], $_POST['birthdate']);
				if ($user)
				{
					// Etape 4
					header('Location: index.php?page=login');
					exit;
				}
				else
				{
					$errors[] = "Erreur interne1";
				}
			}
			catch (Exceptions $e)// ExceptionS
			{
				$errors = $e->getErrors();// ->getMessage() => ->getErrors()
			}
		}
	}

	if ($action == "login")
	{
		// Etape 1
		if (isset($_POST["email"], $_POST["password"])) //correspond aux name dans l'input de phtml dans les [] de POST
		{
			// Etape 2
			$manager = new UserManager($db);
			try
			{
				$user = $manager->findByLogin($_POST['email']);
				if ($user)
				{
					if (password_verify($_POST['password'], $user->getPassword()))
					{
						$_SESSION['id'] = $user->getId();
						$_SESSION['email'] = $user->getEmail();
						$_SESSION['admin'] = $user->isAdmin();
						// Etape 4
						header('Location: index.php?page=categories');
						exit;
					}
					else
					{
						$errors[] = "Mot de passe incorrect";
					}
				}
				else
				{
					$errors[] = "Email inconnu";
				}
			}
			catch (Exceptions $e)// ExceptionS
			{
				$errors = $e->getErrors();// ->getMessage() => ->getErrors()
			}
		}
	}
}