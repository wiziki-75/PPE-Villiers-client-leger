<?php
if(isset($_GET['id'])){
    $deleteUser = $unControleur->changeUserRole($_GET['id']);
    if($deleteUser){
        header('Location: index.php?page=admin&admin=user');
    }
} else {
    header("Location: ../../index.php");
}