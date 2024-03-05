<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $lieu = $unControleur->selectLieu($_GET['id']);
    if (empty($lieu)) {
        die("Le lieu n'existe pas");
    }
} else {
    die("L'id de l'évènement n'a pas été récupéré");
}

if (isset($_POST['lieu'])) {
    $tab = array(
        "idLieu" => $_GET['id'],
        "nom" => $_POST['nom'],
        "capacite" => $_POST['capacite']
    );

    $updateLieu = $unControleur->updateLieu($tab);
    if ($updateLieu) {
        header('Location: index.php?page=admin&admin=lieu');
    }
}

?>

<h1>Modifier un lieu</h1>
<div class="container mt-5 mb-5"> <!-- Notez l'ajout de mb-5 ici pour l'espace en bas -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST">
                <!-- Name field -->
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" id="nom" placeholder="Entrez le nom" value="<?= $lieu['nom'] ?>" required>
                </div>

                <!-- Description field -->
                <div class="mb-3">
                    <label for="description" class="form-label">Adresse</label>
                    <input type="text" name="adresse" class="form-control" id="nom" placeholder="Entrez l'adresse" value="<?= $lieu['adresse'] ?>" disabled>
                </div>

                <!-- Date field -->
                <div class="mb-3">
                    <label for="date" class="form-label">Capacité</label>
                    <input type="text" name="capacite" class="form-control" id="nom" placeholder="Entrez la capacité" value="<?= $lieu['capacite'] ?>" required>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary" name="lieu">Soumettre</button>
            </form>
        </div>
    </div>
</div>