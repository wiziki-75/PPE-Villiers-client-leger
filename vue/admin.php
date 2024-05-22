<?php
if (!isset($_GET['admin'])) {
    die("Pas non trouvé");
}
?>

<style>
    .dropdown-toggle img {
        max-width: 100%;
        max-height: 20px;
        height: auto;
    }
</style>

<div class="container mt-5">
    <h2>Dashboard Administration</h2>
    
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link <?= $_GET['admin'] == 'user' ? 'active' : '' ?>" href="index.php?page=admin&admin=user" data-toggle="tab">Gestion des Utilisateurs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $_GET['admin'] == 'evenement' ? 'active' : '' ?>" href="index.php?page=admin&admin=evenement" data-toggle="tab">Gestion des Événements</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $_GET['admin'] == 'lieu' ? 'active' : '' ?>" href="index.php?page=admin&admin=lieu" data-toggle="tab">Gestion des Lieux</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active">
            <?php

            switch ($_GET['admin']) {
                case 'user':
                    require_once('vue/admin/user_admin.php');
                    break;
                case 'evenement':
                    require_once('vue/admin/evenement_admin.php');
                    break;
                case 'lieu':
                    require_once('vue/admin/lieu_admin.php');
                    break;
                default:
                    require_once("vue/erreur.php");
                    break;
            }
            ?>
        </div>
    </div>
</div>