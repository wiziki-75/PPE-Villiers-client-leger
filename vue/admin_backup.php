<style>
    .dropdown-toggle img {
        max-width: 100%;
        max-height: 20px;
        height: auto;
    }
</style>

<div class="container mt-5">
    <div class="row">
        <!-- Tableau à gauche -->
        <div class="col-md-6">
            <h2>Tableau de Gestion</h2><br>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Courriel</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $users = $unControleur->selectAllUser();
                        foreach ($users as $user) {
                        ?>
                            <tr>
                                <td>
                                    <?php
                                    if ($user['role'] === "participant") {
                                    ?>
                                        <div class="dropdown-center">
                                            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <img class="dropdown-toggle" src="vue/images/bouton-modifier.png">
                                            </button>
                                            <ul class="dropdown-menu">
                                                <form action=""></form>
                                                <li><a class="dropdown-item" href="index.php?page=changeUserRole&id=<?= $user['idUtilisateur'] ?>">Mettre organisateur</a></li>
                                                <li><a class="dropdown-item" href="index.php?page=resetUserMDP&id=<?= $user['idUtilisateur'] ?>">Réinitialiser le mdp</a></li>
                                                <li><a class="link-danger dropdown-item" href="index.php?page=deleteUser&id=<?= $user['idUtilisateur'] ?>">Supprimer</a></li>
                                            </ul>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td><?= $user['nom'] ?></td>
                                <td><?= $user['prenom'] ?></td>
                                <td><?= $user['courriel'] ?></td>
                                <td><?= $user['role'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        <!-- Plus de lignes ici -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tableau des événements à droite -->
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <h2 class="mb-0">Événements</h2>
                <a href="index.php?page=createEvent" class="btn btn-primary ms-3">Ajouter un évènement</a>
            </div><br>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nom</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Lieu</th>
                            <th>Organisateur</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $events = $unControleur->selectAllEvenement();
                        foreach ($events as $event) {
                        ?>
                            <tr>
                                <td>
                                    <div class="dropdown-center">
                                        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <img class="dropdown-toggle" src="vue/images/bouton-modifier.png">
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="index.php?page=eventState&eventState=1&id=<?= $event['idEvenement'] ?>">Confirmé</a></li>
                                            <li><a class="dropdown-item" href="index.php?page=eventState&eventState=2&id=<?= $event['idEvenement'] ?>">En attente</a></li>
                                            <li><a class="dropdown-item" href="index.php?page=eventState&eventState=3&id=<?= $event['idEvenement'] ?>">Annuler</a></li>
                                            <li><a class="dropdown-item" href="index.php?page=eventModif&id=<?= $event['idEvenement'] ?>">Modifier</a></li>
                                            <li><a class="link-danger dropdown-item" href="index.php?page=deleteEvent&id=<?= $event['idEvenement'] ?>">Supprimer</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td><?= $event['nom'] ?></td>
                                <td><?= $event['date'] ?></td>
                                <td><?= $event['type'] ?></td>
                                <td><?= $event['statut'] ?></td>
                                <td><?= $event['adresse_lieu'] ?></td>
                                <td><?= $event['user_courriel'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>