<?php
if (isset($_GET['id']) && isset($_GET['lieuState'])) {
    switch ($_GET['lieuState']) {
        case 1:
            $newlieuState = $unControleur->lieuState($_GET['id'], 'disponible');
            break;
        case 2:
            $newlieuState = $unControleur->lieuState($_GET['id'], 'indisponible');
            break;
        default:
            die("Etat inconnu : " . $_GET['lieuState']);
    }

    if ($newlieuState === true) {
        header('Location: index.php?page=admin&admin=lieu');
    } else {
        echo $newlieuState; // Affiche le message d'erreur retourné par eventState
    }
} else {
    header("Location: ../../index.php");
}
?>
