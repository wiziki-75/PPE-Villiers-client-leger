<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php?page=home">Evenements</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php
                if(!isset($_SESSION['email'])){
                    ?>
                        <li class="nav-item">
                        <a class="nav-link" href="index.php?page=connexion">Se connecter</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="index.php?page=enregistrement">Enregistrement</a>
                        </li>
                    <?php
                } else {
                    ?>
                        <li class="nav-item">
                        <a class="nav-link" href="index.php?page=deconnexion">Se déconnecter</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="index.php?page=profile">Profile</a>
                        </li>
                    <?php
                }
            ?>

            <li class="nav-item">
            <a class="nav-link" href="index.php?page=centre">Centre aéré</a>
            </li>

            <?php
                if(isset($_SESSION['admin'])){
                    ?>
                        <li class="nav-item">
                        <a class="nav-link" href="index.php?page=admin&admin=user">Administration</a>
                        </li>
                    <?php
                }
            ?>
        </ul>
        </div>
    </div>
    </nav>