<?php
class user extends BDD
{

    function verifConnexion($email, $mdp)
    {
        // Étape 1: Récupérer l'utilisateur par l'email
        $requete = "SELECT * FROM user WHERE courriel = :email";
        $donnees = array(":email" => $email);
        $select = $this->unPDO->prepare($requete);
        $select->execute($donnees);
        $resultat = $select->fetch();

        if (!$resultat) {
            // Utilisateur non trouvé
            return false;
        }

        // Étape 2: Vérifier le mot de passe
        if (password_verify($mdp, $resultat['motdepasse'])) {
            // Le mot de passe correspond
            return $resultat;
        } else {
            // Le mot de passe ne correspond pas
            return false;
        }
    }

    function selectAllUser()
    {
        $requete = "SELECT * FROM user;";
        $select = $this->unPDO->query($requete);
        return $select->fetchAll();
    }

    function selectUser($id)
    {
        $requete = $this->unPDO->prepare("SELECT * FROM user WHERE idUtilisateur = :id");
        $requete->bindParam(':id', $id);
        $requete->execute();
        return $requete->fetch();
    }


    function insertUser($tab)
    {
        try {
            // Préparation de la requête SQL
            $requete = $this->unPDO->prepare("INSERT INTO User (nom, prenom, courriel, motdepasse, role) VALUES (:nom, :prenom, :courriel, :motdepasse, :role)");

            // Temporary variables to hold array values
            $nom = $tab['nom'];
            $prenom = $tab['prenom'];
            $courriel = $tab['courriel'];
            $motdepasse = password_hash($tab['password'], PASSWORD_DEFAULT); // Hashage du mot de passe pour la sécurité
            $role = $tab['role'];

            // Liaison des paramètres
            $requete->bindParam(':nom', $nom);
            $requete->bindParam(':prenom', $prenom);
            $requete->bindParam(':courriel', $courriel);
            $requete->bindParam(':motdepasse', $motdepasse);
            $requete->bindParam(':role', $role);

            // Exécution de la requête
            $requete->execute();
            return true;

        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    function updateEmail($id, $email)
    {
        try {
            $requete = $this->unPDO->prepare("UPDATE user SET courriel = :email WHERE idUtilisateur = :id;");
            $requete->bindParam(':email', $email);
            $requete->bindParam(':id', $id);
            $requete->execute();
            $_SESSION['email'] = $email;
            echo "Email changé.";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    function updateEmailPassword($id, $email, $password, $resetMDP)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            if($resetMDP){
                $requete = $this->unPDO->prepare("UPDATE user SET resetMDP = 0, motdepasse = :password WHERE idUtilisateur = :id;");
                $requete->bindParam(':id', $id);
                $requete->bindParam(':password', $hashedPassword);
                $requete->execute();
                return true;
            } else {
                $requete = $this->unPDO->prepare("UPDATE user SET courriel = :email, motdepasse = :password WHERE idUtilisateur = :id;");
                $requete->bindParam(':email', $email);
                $requete->bindParam(':id', $id);
                $requete->bindParam(':password', $hashedPassword);
                $requete->execute();
    
                $_SESSION['email'] = $email;
                echo "Mot de passe changé";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    function changeUserRole($id)
    {
        try {
            $requete = $this->unPDO->prepare("UPDATE user SET role = 'organisateur' WHERE idUtilisateur = :id;");
            $requete->bindParam(':id', $id);
            $requete->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    function userResetMDP($id)
    {
        try {
            $requete = $this->unPDO->prepare("UPDATE user SET resetMDP = 1 WHERE idUtilisateur = :id;");
            $requete->bindParam(':id', $id);
            $requete->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    function deleteUser($id)
    {
        try {
            $requete = $this->unPDO->prepare("DELETE FROM User WHERE idUtilisateur = :id");
            $requete->bindParam(':id', $id);
            $requete->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
