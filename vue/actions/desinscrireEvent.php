<?php
if(isset($_GET['id'])){
    $deleteParticipation = $unControleur->desinscrireEvent($_GET['id']);
    if($deleteParticipation){
        header('Location: index.php?page=profile');
    } else {
        echo "erreur";
    }
} else {
    header("Location: ../../index.php");
}