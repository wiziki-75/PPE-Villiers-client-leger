<?php

if (isset($_POST['event'])) {
  $tab = array(
    "nom" => $_POST['nom'],
    "description" => $_POST['description'],
    "date" => $_POST['date'],
    "type" => $_POST['type'],
    "statut" => "en_attente",
    "organisateurId" => $_SESSION['id'],
    "lieuId" => $_POST['lieu']
  );

  $addEvent = $unControleur->addEvent($tab);
  if ($addEvent) {
    header('Location: index.php?page=admin&admin=evenement');
  }
}

?>

<div class="container mt-5 mb-5"> <!-- Notez l'ajout de mb-5 ici pour l'espace en bas -->
  <div class="row justify-content-center">
    <div class="col-md-8">
    <h1>Ajouter un évènement</h1>
      <form method="POST">
        <!-- Name field -->
        <div class="mb-3">
          <label for="nom" class="form-label">Nom</label>
          <input type="text" name="nom" class="form-control" id="nom" placeholder="Entrez le nom de l'événement" required>
        </div>

        <!-- Description field -->
        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" name="description" id="description" rows="3" placeholder="Entrez une description" required></textarea>
        </div>

        <!-- Date field -->
        <div class="mb-3">
          <label for="date" class="form-label">Date</label>
          <input type="datetime-local" name="date" class="form-control" id="date" required>
        </div>

        <!-- Type dropdown -->
        <div class="mb-3">
          <label for="type" class="form-label">Type</label>
          <select class="form-select" name="type" id="type">
            <option value="Concert">Concert</option>
            <option value="Educatif">Educatif</option>
            <option value="Communautaire">Communautaire</option>
          </select>
        </div>

        <?php
        $lieux = $unControleur->selectAllLieu();
        $lieux_disponibles = [];

        foreach ($lieux as $lieu) {
          if ($lieu['disponibilite'] === "disponible") {
            $lieux_disponibles[] = $lieu;
          }
        }

        if (empty($lieux_disponibles)) {
          die('Aucun lieu disponible.');
        }
        ?>

        <div class="mb-3">
          <label for="lieuId" class="form-label">Lieu disponible</label>
          <select class="form-select" name="lieu" id="lieuId">
            <?php foreach ($lieux_disponibles as $lieu) : ?>
              <option value="<?= htmlspecialchars($lieu['idLieu']) ?>"><?= htmlspecialchars($lieu['adresse']) ?> (<?= htmlspecialchars($lieu['capacite']) ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary" name="event">Soumettre</button>
      </form>
    </div>
  </div>
</div>