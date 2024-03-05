<?php
$evenements = $unControleur->selectAllEvenement();
?>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Nom</th>
            <th scope="col">Date</th>
            <th scope="col">Lieu</th>
            <th scope="col">Statut</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($evenements as $evenement) {
        ?>
            <tr>
                <td><?= $evenement['nom'] ?></td>
                <td><?= $evenement['date'] ?></td>
                <td><?= $evenement['adresse_lieu'] ?></td>
                <td><?= $evenement['statut'] ?></td>

                <td>
                    <?php
                    if ($evenement['statut'] === "confirmé") {
                        $url = "index.php?page=inscriptionEvent&evenement=" . $evenement['idEvenement'];
                        if (isset($_SESSION['email'])) {
                            $participation = $unControleur->checkParticipation($_SESSION['id'], $evenement['idEvenement']);
                            if ($participation) {
                    ?>
                                <button type="button" class="btn btn-success" disabled>Inscris</button>
                            <?php
                            } else {
                                $url .= "&id=" . $_SESSION['id'];
                            ?>
                                <a href="<?= htmlspecialchars($url) ?>" class="btn btn-primary">S'inscrire</a>
                    <?php
                            }
                        }
                    }
                    ?>

                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>