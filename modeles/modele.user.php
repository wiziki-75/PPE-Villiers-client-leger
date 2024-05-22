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
        if ($mdp === $resultat['motdepasse']) {
            return $resultat;
        } else {
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
            $requete = $this->unPDO->prepare("INSERT INTO User (nom, prenom, courriel, motdepasse, role) VALUES (:nom, :prenom, :courriel, :motdepasse, :role)");
            $nom = $tab['nom'];
            $prenom = $tab['prenom'];
            $courriel = $tab['courriel'];
            $motdepasse = $tab['password'];
            $role = $tab['role'];

            $requete->bindParam(':nom', $nom);
            $requete->bindParam(':prenom', $prenom);
            $requete->bindParam(':courriel', $courriel);
            $requete->bindParam(':motdepasse', $motdepasse);
            $requete->bindParam(':role', $role);

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
            //Changer l'email de la session
            $_SESSION['email'] = $email;
            echo "Email changé.";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    function updateEmailPassword($id, $email, $password, $resetMDP)
    {
        try {
            if($resetMDP){
                $requete = $this->unPDO->prepare("UPDATE user SET resetMDP = 0, motdepasse = :password WHERE idUtilisateur = :id;");
                $requete->bindParam(':id', $id);
                $requete->bindParam(':password', $password);
                $requete->execute();
                return true;
            } else {
                $requete = $this->unPDO->prepare("UPDATE user SET courriel = :email, motdepasse = :password WHERE idUtilisateur = :id;");
                $requete->bindParam(':email', $email);
                $requete->bindParam(':id', $id);
                $requete->bindParam(':password', $password);
                $requete->execute();
                //Changer l'email de la session
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
