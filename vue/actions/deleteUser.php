<?php
if(isset($_GET['id'])){
    $deleteUser = $unControleur->deleteUser($_GET['id']);
    if($deleteUser){
        header('Location: index.php?page=admin&admin=user');
    } else {
        echo $deleteUser;
        echo "Erreur lors de la tentative de suppresion";
    }
} else {
    header("Location: ../../index.php");
}