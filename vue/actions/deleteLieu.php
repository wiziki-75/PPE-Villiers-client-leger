<?php
if(isset($_GET['id'])){
    $deleteLieu = $unControleur->deleteLieu($_GET['id']);
    if($deleteLieu){
        header('Location: index.php?page=admin&admin=lieu');
    } else {
        echo $deleteLieu;
    }
} else {
    header("Location: ../../index.php");
}