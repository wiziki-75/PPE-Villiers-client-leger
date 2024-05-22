<br>
<div class="d-flex align-items-center">
    <h2 class="mb-0">Lieux</h2>
    <a href="index.php?page=createLieu" class="btn btn-primary ms-3">Ajouter un lieu</a>
</div><br>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th></th>
            <th>Nom</th>
            <th>Adresse</th>
            <th>Capacité</th>
            <th>Disponibilité</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $lieux = $unControleur->selectAllLieu();
        foreach ($lieux as $lieu) {
        ?>
            <tr class="
    <?php
            if ($lieu['disponibilite'] === 'disponible') {
                echo 'table-success';
            } elseif ($lieu['disponibilite'] === 'indisponible') {
                echo 'table-danger';
            } else {
                echo 'table-warning';
            }
    ?>">
                <td>
                    <div class="dropdown-center">
                        <?php
                        if ($lieu['disponibilite'] !== 'réservé') {
                        ?>
                            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="dropdown-toggle" src="vue/images/bouton-modifier.png">
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="index.php?page=lieuState&id=<?= $lieu['idLieu'] ?>&lieuState=1">Disponible</a></li>
                                <li><a class="dropdown-item" href="index.php?page=lieuState&id=<?= $lieu['idLieu'] ?>&lieuState=2">Indisponible</a></li>
                                <li><a class="dropdown-item" href="index.php?page=lieuModif&id=<?= $lieu['idLieu'] ?>">Modifier</a></li>
                                <li><a class="link-danger dropdown-item" href="index.php?page=deleteLieu&id=<?= $lieu['idLieu'] ?>">Supprimer</a></li>
                            </ul>
                        <?php
                        }
                        ?>
                    </div>
                </td>
                <td><?= $lieu['nom'] ?></td>
                <td><?= $lieu['adresse'] ?></td>
                <td><?= $lieu['capacite'] ?></td>
                <td><?= $lieu['disponibilite'] ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table><br>