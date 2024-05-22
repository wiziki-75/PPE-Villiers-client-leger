<?php
if(isset($_GET['id'])){
    $deleteParticipation = $unControleur->desinscrireEvent($_GET['id']);
    if($deleteParticipation){
        header('Location: index.php?page=profile');
    } else {
        echo $deleteParticipation;
        echo "Erreur lors de la tentative de desinscription";
    }
} else {
    header("Location: ../../index.php");
}