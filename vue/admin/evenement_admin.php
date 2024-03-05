<br><div class="d-flex align-items-center">
                <h2 class="mb-0">Événements</h2>
                <a href="index.php?page=createEvent" class="btn btn-primary ms-3">Ajouter un évènement</a>
            </div><br>

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
            <th>Nombre d'inscris</th>
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
                <td class="text-center h4"><?= $event['nombre_inscrits'] ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table><br>