<?php
if(isset($_GET['id'])){
    $deleteEvent = $unControleur->deleteEvent($_GET['id']);
    if($deleteEvent){
        header('Location: index.php?page=admin&admin=evenement');
    }
} else {
    header("Location: ../../index.php");
}