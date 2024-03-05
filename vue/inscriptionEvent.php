<?php

if(isset($_GET['evenement']) && isset($_GET['id']) && isset($_SESSION['email'])){
  $inscriptionSuccessful = $unControleur->inscriptionEvenement($_GET['id'], $_GET['evenement']);

  if (!$inscriptionSuccessful) {
      echo 'Erreur lors de l\'inscription à l\'événement.';
  } else {
      header('Location: index.php');
  }
} else {
    echo 'Inscription impossible';
}
