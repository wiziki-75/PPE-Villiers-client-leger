<?php

if (isset($_POST['enregistrer'])) {
  if ($_POST['password'] === $_POST['password2']) {
    $_POST['role'] = 'participant';
    $newUser = $unControleur->insertUser($_POST);

    if ($newUser) {
      header("Location: index.php?page=connexion");
    }
  } else {
    echo "Les mots de passes ne sont pas identiques";
  }
}

?>

<div class="container mt-5 mb-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h1>Enregistrement</h1>

      <form method="post">
        <div class="mb-3">
          <label for="nom" class="form-label">nom</label>
          <input type="nom" class="form-control" id="nom" aria-describedby="emailHelp" name="nom" required>
        </div>

        <div class="mb-3">
          <label for="prenom" class="form-label">prenom</label>
          <input type="prenom" class="form-control" id="prenom" aria-describedby="emailHelp" name="prenom" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="courriel" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Mot de passe</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
          <label for="password2" class="form-label">Confirmation du mot de passe</label>
          <input type="password" class="form-control" id="password2" name="password2" required>
        </div>

        <button type="submit" class="btn btn-primary" name="enregistrer">S'enregistrer</button>
      </form>

    </div>
  </div>
</div>