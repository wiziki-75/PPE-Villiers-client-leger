<?php
if (!isset($_GET['evenement'])) {
    die("Evenement introuvable");
}

$event = $unControleur->selectEvent($_GET['evenement']);
$url = "index.php?page=inscriptionEvent&evenement=" . $event['idEvenement'];
$today = new DateTime();
$eventDate = new DateTime($event['date']);
?>

<!-- Product section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <?php
            switch ($event['type']) {
                case 'Concert':
                    $img = "vue/images/concert.jpg";
                    break;
                case 'Educatif':
                    $img = "vue/images/educatif.png";
                    break;
                case 'Communautaire':
                    $img = "vue/images/communautaire.jpg";
                    break;
            }
            ?>
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="<?= $img ?>" /></div>
            <div class="col-md-6">
                <h1 class="display-5 fw-bolder"><?= htmlspecialchars($event['nom']) ?></h1>
                <p class="lead">Organisé par : <strong><?= $event['user_prenom'] . " " . $event['user_nom'] ?></strong></p>
                <p class="lead"><strong><?= htmlspecialchars($event['date']) ?></strong></p>
                <p class="lead"><strong><?= htmlspecialchars($event['adresse_lieu']) ?></strong></p>
                <p class="lead"><?= htmlspecialchars($event['description']) ?></p>
                
                <div class="d-flex">
                    <?php
                    if (isset($_SESSION['email']) && $eventDate > $today && $event['statut'] === "confirmé") {
                        $participation = $unControleur->checkParticipation($_SESSION['id'], $event['idEvenement']);
                        if ($participation) {
                    ?>
                            <button type="button" class="btn btn-success" disabled>Inscris</button>
                        <?php
                        } else {
                        ?>
                            <a class="btn btn-outline-dark mt-auto" href="<?= htmlspecialchars($url) ?>">S'inscrire</a>
                    <?php
                        }
                    } else if(isset($_SESSION['email']) && $eventDate > $today && $event['statut'] === "annulé"){
                        ?>
                            <button type="button" class="btn btn-danger" disabled>Annulé</button>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Assurez-vous de définir la variable $Allavis en dehors de toute condition
if ($eventDate < $today) {
    $Allavis = $unControleur->selectAllAvisByEvent($_GET['evenement']);
    if (isset($_SESSION['id'])) {
        $userCheck = $unControleur->avisCheck($_GET['evenement'], $_SESSION['id']);
    }
}
?>

<?php if ($eventDate < $today) : ?>
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <?php
                    // Affichage du formulaire si l'événement est passé et l'utilisateur est connecté
                    if (isset($_SESSION['id']) && $userCheck[0][0] == 0) {
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['note'])) {
                            $tab = array(
                                "note" => $_POST['note'],
                                "description" => $_POST['description'],
                                "idEvenement" => $_POST['idEvenement'],
                                "idUtilisateur" => $_POST['idUtilisateur']
                            );
                            $addAvis = $unControleur->addAvis($tab);

                            if (!$addAvis) {
                                echo "Erreur dans la création de l'avis";
                                header('Location: index.php');
                                exit;
                            } else {
                                // Rafraîchir les avis après l'ajout d'un nouvel avis
                                header('Location: index.php?page=eventDetail&evenement=' . $_GET['evenement']);
                            }
                        }
                    ?>

                        <h4 class="mb-3">Ajouter un avis</h4>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="note" class="form-label">Note</label>
                                <select class="form-select" id="note" name="note">
                                    <option value="1">1 Étoile</option>
                                    <option value="2">2 Étoiles</option>
                                    <option value="3">3 Étoiles</option>
                                    <option value="4">4 Étoiles</option>
                                    <option value="5">5 Étoiles</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Commentaire</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <input type="hidden" id="idEvenement" name="idEvenement" value="<?= htmlspecialchars($_GET['evenement']) ?>">
                            <input type="hidden" id="idUtilisateur" name="idUtilisateur" value="<?= htmlspecialchars($_SESSION['id']) ?>">
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </form>
                    <?php
                    }
                    ?>

                    <!-- Affichage des avis si l'événement est passé -->
                    <div class="col-md-8 mt-5">
                        <h4 class="mb-3">Avis publiés</h4>
                        <ul class="list-group">
                            <?php
                            if (empty($Allavis)) {
                                echo '<li class="list-group-item">Aucun avis pour cet événement.</li>';
                            } else {
                                foreach ($Allavis as $avis) {
                            ?>
                                    <li class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1"><?= $avis['prenom'] . " " . $avis['nom'] ?></h5>
                                            <small>
                                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                    <i class="<?= $i <= $avis['note'] ? 'fas' : 'far' ?> fa-star"></i>
                                                <?php endfor; ?>
                                            </small>
                                        </div>
                                        <p class="mb-1"><?= htmlspecialchars($avis['description']) ?></p>
                                    </li>
                            <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>