<br>
<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- Groupe de gauche pour le titre et le bouton d'ajout -->
    <div class="d-flex align-items-center">
        <h2 class="mb-0">Événements</h2>
        <a href="index.php?page=createEvent" class="btn btn-primary ms-3">Ajouter un évènement</a>
    </div>

    <!-- Bouton switch aligné à droite -->
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="eventSwitch">
        <label class="form-check-label" for="eventSwitch">Afficher les événements passés</label>
    </div>
</div>

<table class="table table-striped table-bordered" id="currentEvents">

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
        $presentEvents = $unControleur->selectAllEvenement('present');
        foreach ($presentEvents as $event) {
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
                <td class="text-center h4"><?= $event['nombre_inscrits'] ?> / <?= $event['capacite'] ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<table class="table table-striped table-bordered d-none" id="pastEvents">

    <thead>
        <tr>
            <th></th>
            <th>Nom2</th>
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
        $pastEvents = $unControleur->selectAllEvenement('past');
        foreach ($pastEvents as $event) {
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
                <td class="text-center h4"><?= $event['nombre_inscrits'] ?> / <?= $event['capacite']?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<script>
document.getElementById('eventSwitch').addEventListener('change', function() {
    var checkBox = document.getElementById("eventSwitch");
    var currentEventsTable = document.getElementById("currentEvents");
    var pastEventsTable = document.getElementById("pastEvents");

    if (checkBox.checked) {
        currentEventsTable.classList.add('d-none');
        pastEventsTable.classList.remove('d-none');
    } else {
        currentEventsTable.classList.remove('d-none');
        pastEventsTable.classList.add('d-none');
    }
});
</script>