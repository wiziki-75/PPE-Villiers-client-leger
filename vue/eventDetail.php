<?php
if (!isset($_GET['evenement'])) {
    die("Evenement introuvable");
}

$event = $unControleur->selectEvent($_GET['evenement']);

?>

<!-- Product section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="https://dummyimage.com/600x700/dee2e6/6c757d.jpg" alt="..." /></div>
            <div class="col-md-6">
                <h1 class="display-5 fw-bolder"><?= $event['nom'] ?></h1>
                <p class="lead"><?= $event['description'] ?></p>
                <div class="d-flex">
                    <!-- <input class="form-control text-center me-3" id="inputQuantity" type="num" value="1" style="max-width: 3rem" /> -->
                    <a class="btn btn-outline-dark mt-auto" href="<?= htmlspecialchars($url) ?>">S'inscrire</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container-fluid"> <!-- Utilisation de 'container-fluid' pour une largeur complète -->
        <h2 class="fw-bolder mb-4 text-center">Avis</h2> <!-- Centrage du titre -->
        <div class="row justify-content-center">
            <!-- Formulaire pour ajouter un avis -->
            <div class="col-lg-10">
                <h4 class="mb-3">Ajouter un avis</h4>
                <form>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Note</label>
                        <select class="form-select" id="rating">
                            <option value="1">1 Étoile</option>
                            <option value="2">2 Étoiles</option>
                            <option value="3">3 Étoiles</option>
                            <option value="4">4 Étoiles</option>
                            <option value="5">5 Étoiles</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Commentaire</label>
                        <textarea class="form-control" id="comment" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>

            <!-- Section pour afficher les avis publiés -->
            <div class="col-lg-10 mt-5">
                <h4 class="mb-3">Avis publiés</h4>
                <ul class="list-group">
                    <li class="list-group-item">Avis 1: ★★★★★ "Excellent produit!"</li>
                    <li class="list-group-item">Avis 2: ★★★★☆ "Très bon, mais pourrait être amélioré."</li>
                </ul>
            </div>
        </div>
    </div>
</section>