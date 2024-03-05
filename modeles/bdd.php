<?php
class BDD {
    public $unPDO; // Objet PDO

    public function __construct(){
        $url = "mysql:host=localhost;dbname=gestionevenements";
        $user = "root";
        $mdp = "";

        try {
            // Instanciation de la classe PDO
            $this->unPDO = new PDO($url, $user, $mdp);
            $this->unPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Définir le mode d'erreur
        } catch (PDOException $exp) {
            die("Erreur connexion BDD : " . $exp->getMessage());
        }
    }
}

?>