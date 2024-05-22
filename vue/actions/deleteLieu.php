<?php
if(isset($_GET['id'])){
    $deleteLieu = $unControleur->deleteLieu($_GET['id']);
    if($deleteLieu){
        header('Location: index.php?page=admin&admin=lieu');
    } else {
        echo $deleteLieu;
        echo "Erreur lors de la tentative de suppresion";
    }
} else {
    header("Location: ../../index.php");
}