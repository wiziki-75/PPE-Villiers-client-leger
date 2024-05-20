<?php

if(isset($_POST['lieu'])){
  $tab = array(
    "nom" => $_POST['nom'],
    "adresse" => $_POST['adresse'],
    "capacite" => $_POST['capacite'],
    "disponibilite" => $_POST['disponibilite']
  );

  $addLieu = $unControleur->addLieu($tab);
  if($addLieu){
    header('Location: index.php?page=admin&admin=lieu');
  } else {
    echo 'Erreur dans la création du lieu';
    echo $addlieu;
  }

}

?>

<h1>Ajouter un lieu</h1>
<div class="container mt-5 mb-5"> <!-- Notez l'ajout de mb-5 ici pour l'espace en bas -->
  <div class="row justify-content-center">
    <div class="col-md-8">
      <form method="POST">
        <!-- Name field -->
        <div class="mb-3">
          <label for="nom" class="form-label">Nom</label>
          <input type="text" name="nom" class="form-control" id="nom" placeholder="Entrez le nom" required>
        </div>

        <!-- Description field -->
        <div class="mb-3">
          <label for="description" class="form-label">Adresse</label>
          <input type="text" name="adresse" class="form-control" id="nom" placeholder="Entrez l'adresse" required>
        </div>

        <!-- Date field -->
        <div class="mb-3">
          <label for="date" class="form-label">Capacité</label>
          <input type="text" name="capacite" class="form-control" id="nom" placeholder="Entrez la capacité" required>
        </div>

        <!-- Type dropdown -->
        <div class="mb-3">
          <label for="type" class="form-label">Disponibilité</label>
          <select class="form-select" name="disponibilite" id="type">
            <option value="disponible">disponible</option>
            <option value="indisponible">indisponible</option>
          </select>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary" name="lieu">Soumettre</button>
      </form>
    </div>
  </div>
</div>