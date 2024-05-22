<div class="container mt-5">
    <div class="row">
        <!-- Tableau à gauche -->
        <div class="col-md-6">
            <?php
            if (isset($_POST['password'])) {
                $user = $unControleur->verifConnexion($_SESSION['email'], $_POST['password']);
                if ($user != null) {
                    $data = $unControleur->selectUser($_SESSION['id']);
                    require_once('user_update.php');
                } else {
            ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Entrer votre mot de passe pour accéder à vos données personnelles</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                            <div id="emailHelp" class="form-text">Mot de passe incorrect.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </form>
                <?php
                }
            } else {
                ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Entrer votre mot de passe pour accéder à vos données personnelles</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Soumettre</button>
                </form>
            <?php
            }

            if (isset($_POST['email'])) {
                if ($_POST['password1'] !== '' && $_POST['password2'] !== '') {
                    if ($_POST['password1'] === $_POST['password2']) {
                        $unControleur->updateEmailPassword($_SESSION['id'], $_POST['email'], $_POST['password2'], false);
                    } else {
                        echo "Les mots de passes ne sont pas identiques";
                    }
                } else if ($_POST['password1'] == '' && $_POST['password2'] !== '') {
                    echo "Vous devez confirmer le mot de passe";
                } else if ($_POST['password1'] !== '' && $_POST['password2'] == '') {
                    echo "Vous devez confirmer le mot de passe";
                } else {
                    $unControleur->updateEmail($_SESSION['id'], $_POST['email']);
                }
            }
            ?>

        </div>

        <!-- Tableau des événements à droite -->
        <div class="col-md-6">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Lieu</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $participations = $unControleur->selectParticipation($_SESSION['id']);

                    foreach ($participations as $participation) {
                    ?>
                        <tr>
                            <td><?= $participation['nom'] ?></td>
                            <td><?= $participation['date'] ?></td>
                            <td><?= $participation['type'] ?></td>
                            <td><?= $participation['adresse_lieu'] ?></td>
                            <td><a class="btn btn-danger" href="index.php?page=desinscrireEvent&id=<?= $participation['idParticipation'] ?>">Se désinscrire</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>