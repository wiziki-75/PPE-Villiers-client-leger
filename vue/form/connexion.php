<?php
if (isset($_POST['connexion'])) {
  $email = $_POST['email'];
  $mdp = $_POST['password'];
  $unUser = $unControleur->verifConnexion($email, $mdp);
  if ($unUser != null) {
    $_SESSION['id'] = $unUser['idUtilisateur'];
    if ($unUser['resetMDP']) {
      $_SESSION['email_temp'] = $email;
      $_SESSION['ancienMDP'] = $mdp;
      $_SESSION['mdpRESET'] = true;
      require_once('vue/form/changeMDP.php');

    } else {
      $_SESSION['email'] = $unUser['courriel'];
      $_SESSION['nom'] = $unUser['nom'];
      $_SESSION['prenom'] = $unUser['prenom'];
      $_SESSION['role'] = $unUser['role'];
      if ($_SESSION['role'] === 'organisateur') {
        $_SESSION['admin'] = 1;
      }
      //$unControleur->insertLogs("login");
      header("Location: index.php");
    }
  } else {
    echo "<br> Logs incorrect.";
  }
} else if(isset($_SESSION['mdpRESET'])){
  if (isset($_POST['valider'])) {
    $unUser = $unControleur->verifConnexion($_SESSION['email_temp'], $_SESSION['ancienMDP']);
    if ($_POST['password'] === $_POST['password2']) {
      if ($_POST['password'] !== $_SESSION['ancienMDP']) {
        $mdpRESET = $unControleur->updateEmailPassword($_SESSION['id'], $_SESSION['email_temp'], $_POST['password'], true);
        if($mdpRESET){
          $_SESSION['email'] = $unUser['courriel'];
          $_SESSION['nom'] = $unUser['nom'];
          $_SESSION['prenom'] = $unUser['prenom'];
          $_SESSION['role'] = $unUser['role'];
          if ($_SESSION['role'] === 'organisateur') {
            $_SESSION['admin'] = 1;
          }
          //$unControleur->insertLogs("login");
          unset($_SESSION['email_temp']);
          unset($_SESSION['mdpRESET']);
          header("Location: index.php");
        } else {
          echo "Erreur";
        }
      } else { 
        unset($_SESSION['email_temp']);
        unset($_SESSION['mdpRESET']);
        echo "Le nouveau mot de passe ne peut pas être le même que l'ancien";
      }
    } else {
      unset($_SESSION['email_temp']);
      unset($_SESSION['mdpRESET']);
      echo "Les mots de passes ne sont pas identiques";
    }
  }
} else {
?>
  <h1>Se connecter</h1>
  <form method="post">
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" name="email" aria-describedby="emailHelp" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Mot de passe</label>
      <input type="password" class="form-control" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary" name="connexion">Se connecter</button>
  </form>
<?php
}
?>