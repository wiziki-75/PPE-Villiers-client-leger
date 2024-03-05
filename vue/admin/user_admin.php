<br>
<div class="d-flex align-items-center">
    <h2 class="mb-0">Utilisateurs</h2>
</div><br>

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
</table><br>