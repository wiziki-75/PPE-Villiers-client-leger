<?php
if(isset($_GET['id'])){
    $deleteUser = $unControleur->changeUserRole($_GET['id']);
    if($deleteUser){
        header('Location: index.php?page=admin&admin=user');
    } else {
        echo $deleteUser;
        echo 'Erreur lors du changement de role';
    }
} else {
    header("Location: ../../index.php");
}