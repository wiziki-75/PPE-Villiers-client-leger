<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $event = $unControleur->selectEvent($_GET['id']);
    if (empty($event)) {
        die("L'évènement n'existe pas");
    }
} else {
    die("L'id de l'évènement n'a pas été récupéré");
}

if (isset($_POST['event'])) {
    $tab = array(
        "idEvenement" => $_GET['id'],
        "nom" => $_POST['nom'],
        "description" => $_POST['description'],
        "date" => $_POST['date'],
        "type" => $_POST['type'],
        "lieuId" => $_POST['lieu']
    );

    $updateEvent = $unControleur->updateEvent($tab);
    if($updateEvent){
        header('Location: index.php?page=admin&admin=evenement');
    }
}

?>

<h1>Modifier un évènement</h1>
<div class="container mt-5 mb-5"> <!-- Notez l'ajout de mb-5 ici pour l'espace en bas -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST">
                <!-- Name field -->
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input value="<?= $event['nom'] ?>" type="text" name="nom" class="form-control" id="nom" placeholder="Entrez le nom de l'événement" required>
                </div>

                <!-- Description field -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" name="description" id="description" rows="3" placeholder="Entrez une description" required><?= $event['description'] ?></textarea>
                </div>

                <!-- Date field -->
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input value="<?= $event['date'] ?>" type="datetime-local" name="date" class="form-control" id="date" required>
                </div>

                <!-- Type dropdown -->
                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select" name="type" id="type">
                        <option value="Concert" <?= $event['type'] == 'Concert' ? 'selected' : '' ?>>Concert</option>
                        <option value="Culturel" <?= $event['type'] == 'Culturel' ? 'selected' : '' ?>>Culturel</option>
                        <option value="Educatif" <?= $event['type'] == 'Educatif' ? 'selected' : '' ?>>Educatif</option>
                        <option value="Communautaire" <?= $event['type'] == 'Communautaire' ? 'selected' : '' ?>>Communautaire</option>
                    </select>
                </div>

                <!-- Lieu ID field -->
                <div class="mb-3">
                    <label for="lieuId" class="form-label">Lieu disponible</label>
                    <select class="form-select" name="lieu" id="statut">
                        <?php
                        $lieux = $unControleur->selectAllLieu();

                        foreach ($lieux as $lieu) {
                            if ($lieu['disponibilite'] === "disponible") {
                        ?>
                                <option value="<?= $lieu['idLieu'] ?>" <?= $event['lieuId'] == $lieu['idLieu'] ? 'selected' : '' ?>><?= $lieu['adresse'] ?> (<?= $lieu['capacite'] ?>)</option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary" name="event">Soumettre</button>
            </form>
        </div>
    </div>
</div>