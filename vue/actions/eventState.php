<?php
if (isset($_GET['id']) && isset($_GET['eventState'])) {
    switch ($_GET['eventState']) {
        case 1:
            $newEventState = $unControleur->eventState($_GET['id'], 'confirmé');
            break;
        case 2:
            $newEventState = $unControleur->eventState($_GET['id'], 'en_attente');
            break;
        case 3:
            $newEventState = $unControleur->eventState($_GET['id'], 'annulé');
            break;
        default:
            die("Etat inconnu : " . $_GET['eventState']);
    }

    if ($newEventState === true) {
        header('Location: index.php?page=admin&admin=evenement');
    } else {
        echo $newEventState; // Affiche le message d'erreur retourné par eventState
    }
} else {
    header("Location: ../../index.php");
}
?>
