<?php
session_start();
session_regenerate_id(true);

require_once("controleur/controleur.class.php");
$unControleur = new Controleur();
?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Mairie de Villiers</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</head>

<body>
	<?php require_once('vue/navbar.php');

	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 'home';
	}
	switch ($page) {
			// page d'acceuil
		case 'home':
			require_once("vue/home.php");
			break;
			// page de connexion
		case 'connexion':
			isset($_SESSION['email']) ? header('Location: index.php') : require_once("vue/form/connexion.php");
			break;
			//page du profile
		case 'profile':
			!isset($_SESSION['email']) ? require_once("vue/non_connecte.php") : require_once("vue/profile.php");
			break;
			//page du centre aéré
		case 'centre':
			require_once("vue/centre.php");
			break;
			//page d'administration
		case 'admin':
			if (isset($_SESSION['role'])) {
				if ($_SESSION['role'] === 'organisateur') {
					require_once("vue/admin.php");
				} else {
					require_once("vue/acces.php");
				}
			} else {
				require_once("vue/acces.php");
			}
			break;
			//page de création de compte
		case 'enregistrement':
			isset($_SESSION['email']) ? header('Location: index.php') : require_once("vue/form/enregistrement.php");
			break;
			//action pour s'inscrire à un évènement
		case 'inscriptionEvent':
			!isset($_SESSION['email']) ? require_once("vue/non_connecte.php") : require_once("vue/inscriptionEvent.php");
			break;
			//action pour supprimer un utilisateur
		case 'deleteUser':
			!isset($_SESSION['admin']) ? header('Location: index.php') : require_once("vue/actions/deleteUser.php");
			break;
			//action pour changer un utilisateur de role
		case 'changeUserRole':
			!isset($_SESSION['admin']) ? header('Location: index.php') : require_once("vue/actions/changeUserRole.php");
			break;
			//action pour changer le mot de passe d'un utilisateur 
		case 'resetUserMDP':
			!isset($_SESSION['admin']) ? header('Location: index.php') : require_once("vue/actions/resetUserMDP.php");
			break;
			//action pour se désinscrire un utilisateur d'un évènement
		case 'desinscrireEvent':
			!isset($_SESSION['email']) ? require_once("vue/non_connecte.php") : require_once("vue/actions/desinscrireEvent.php");
			break;
			//changer l'état d'un evenment
		case 'eventState':
			!isset($_SESSION['admin']) ? header('Location: index.php') : require_once("vue/actions/eventState.php");
			break;
			// Supprimer un évènement
		case 'deleteEvent':
			!isset($_SESSION['admin']) ? header('Location: index.php') : require_once("vue/actions/deleteEvent.php");
			break;
			//Modifier un évènement
		case 'changeEvent':
			!isset($_SESSION['admin']) ? header('Location: index.php') : require_once("vue/erreur.php");
			break;
			//créer un évènement
		case 'createEvent':
			!isset($_SESSION['admin']) ? header('Location: index.php') : require_once("vue/form/createEvent.php");
			break;
			//Modifié un évènement
		case 'eventModif':
			!isset($_SESSION['admin']) ? header('Location: index.php') : require_once("vue/form/modifEvent.php");
			break;
			// changer l'état d'un lieu
		case 'lieuState':
			!isset($_SESSION['admin']) ? header('Location: index.php') : require_once("vue/actions/lieuState.php");
			break;
			// Supprimer un lieu
		case 'deleteLieu':
			!isset($_SESSION['admin']) ? header('Location: index.php') : require_once("vue/actions/deleteLieu.php");
			break;
			//créer un lieu
		case 'createLieu':
			!isset($_SESSION['admin']) ? header('Location: index.php') : require_once("vue/form/createLieu.php");
			break;
			//Modifié un évènement
		case 'lieuModif':
			!isset($_SESSION['admin']) ? header('Location: index.php') : require_once("vue/form/modifLieu.php");
			break;
			//action pour se déconnecter
		case 'deconnexion':
			//$unControleur->insertLogs("logoff");
			session_destroy();
			unset($_SESSION);
			header("Location: index.php");
			break;
			//page d'erreur si page non trouvé
		default:
			require_once("vue/erreur.php");
			break;
	}

	?>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>