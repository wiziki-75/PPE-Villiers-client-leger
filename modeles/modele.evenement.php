<?php
class evenement extends BDD
{
    public function selectAllEvenement($type = 'all')
    {
        $condition = '';

        switch ($type) {
            case 'past':
                $condition = "WHERE evenement.date < NOW()";
                break;
            case 'present':
                $condition = "WHERE evenement.date > NOW()";
                break;
            case 'all':
            default:
                break;
        }

        $requete = "SELECT evenement.*, 
                    lieu.adresse AS adresse_lieu, 
                    lieu.capacite,
                    user.courriel AS user_courriel,
                    user.nom AS user_nom,
                    user.prenom AS user_prenom,
                    COUNT(participation.idEvenement) AS nombre_inscrits
                    FROM evenement
                    JOIN lieu ON evenement.lieuId = lieu.idLieu
                    LEFT JOIN user ON evenement.organisateurId = user.idUtilisateur
                    LEFT JOIN participation ON evenement.idEvenement = participation.idEvenement
                    $condition
                    GROUP BY evenement.idEvenement, lieu.adresse, lieu.capacite, user.courriel;
                    ";

        $select = $this->unPDO->query($requete);
        return $select->fetchAll();
    }



    public function selectEvent($id)
    {
        $requete = $this->unPDO->prepare("SELECT evenement.*, 
        lieu.adresse AS adresse_lieu, 
        user.courriel AS user_courriel,
        user.nom AS user_nom,
        user.prenom AS user_prenom
        FROM evenement
        LEFT JOIN lieu ON evenement.lieuId = lieu.idLieu
        JOIN user ON evenement.organisateurId = user.idUtilisateur
        WHERE evenement.idEvenement = :id;");

        $requete->bindParam(':id', $id);
        $requete->execute();
        return $requete->fetch();
    }

    public function addEvent($tab)
    {
        try {
            $requete = $this->unPDO->prepare("INSERT INTO evenement (nom, description, date, type, statut, organisateurId, lieuId) 
            VALUES (:nom, :description, :date, :type, :statut, :organisateurId, :lieuId);");

            // Boucle pour lier automatiquement chaque paramètre
            foreach ($tab as $param => $value) {
                $requete->bindParam(':' . $param, $tab[$param]);
            }

            $requete->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    public function updateEvent($tab)
    {
        try {
            $id = $tab['idEvenement'];
            unset($tab['idEvenement']); // Retirer l'identifiant du tableau pour éviter de le mettre à jour

            $sql = "UPDATE evenement SET ";

            $setParts = [];
            foreach ($tab as $param => $value) {
                $setParts[] = "$param = :$param";
            }
            $sql .= implode(', ', $setParts);

            $sql .= " WHERE idEvenement = :idEvenement;";

            $requete = $this->unPDO->prepare($sql);

            foreach ($tab as $param => $value) {
                $requete->bindValue(':' . $param, $value);
            }

            $requete->bindValue(':idEvenement', $id);

            $requete->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour : " . $e->getMessage();
            return false;
        }
    }

    public function inscriptionEvenement($idParticipant, $idEvenement)
    {
        try {
            $requete = $this->unPDO->prepare("INSERT INTO participation (idParticipant, idEvenement) VALUES (:idParticipant, :idEvenement)");
            $requete->bindParam(':idParticipant', $idParticipant);
            $requete->bindParam(':idEvenement', $idEvenement);

            $requete->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Erreur lors de l'inscription à l'événement: " . $e->getMessage());
            return false;
        }
    }

    public function desinscrireEvent($id)
    {
        try {
            $requete = $this->unPDO->prepare("DELETE FROM participation WHERE idParticipation = :id;");
            $requete->bindParam(':id', $id);
            $requete->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Erreur lors de l'inscription à l'événement: " . $e->getMessage());
            return false;
        }
    }

    public function checkParticipation($idParticipant, $idEvenement)
    {
        $requete = $this->unPDO->prepare("SELECT * FROM participation WHERE idParticipant = :idParticipant AND idEvenement = :idEvenement;");
        $requete->bindParam(':idParticipant', $idParticipant);
        $requete->bindParam(':idEvenement', $idEvenement);
        $requete->execute();
        $resultat = $requete->fetch();
        return $resultat ? true : false;
    }

    public function selectParticipation($id)
    {
        $requete = $this->unPDO->prepare(
            "SELECT participation.*, Evenement.nom, Evenement.description, Evenement.date, Evenement.type, Evenement.statut, Evenement.organisateurId, Evenement.lieuId,
        lieu.adresse AS adresse_lieu
        FROM participation
        JOIN Evenement ON participation.idEvenement = Evenement.idEvenement
        JOIN lieu ON evenement.lieuId = lieu.idLieu
        WHERE participation.idParticipant = :id;
        "
        );
        $requete->bindParam(':id', $id);
        $requete->execute();
        return $requete->fetchAll();
    }

    public function eventState($id, $state)
    {
        try {
            $requete = $this->unPDO->prepare("UPDATE evenement SET statut = :state WHERE idEvenement = :id;");
            $requete->bindParam(':state', $state);
            $requete->bindParam(':id', $id);
            $requete->execute();

            if ($requete->rowCount() > 0) {
                return true; // L'opération a réussi
            } else {
                return "Aucune modification effectuée. Vérifiez l'ID de l'événement.";
            }
        } catch (PDOException $e) {
            error_log("Erreur lors de la modification de l'état de l'événement: " . $e->getMessage());
            return "Erreur lors de la modification de l'état de l'événement.";
        }
    }

    public function deleteEvent($id)
    {
        try {
            $requete = $this->unPDO->prepare("DELETE FROM evenement WHERE idEvenement = :id");
            $requete->bindParam(':id', $id);
            $requete->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    // === AVIS ===

    public function addAvis($tab)
    {
        try {
            $requete = $this->unPDO->prepare("INSERT INTO avis (note, description, idEvenement, idUtilisateur) 
            VALUES (:note, :description, :idEvenement, :idUtilisateur);");

            foreach ($tab as $param => $value) {
                $requete->bindParam(':' . $param, $tab[$param]);
            }

            $requete->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    public function selectAllAvisByEvent($idEvent)
    {
        $requete = $this->unPDO->prepare("SELECT avis.*, user.nom, user.prenom FROM avis 
        LEFT JOIN user ON avis.idUtilisateur = user.idUtilisateur
        WHERE idEvenement = :idEvenement;");
        $requete->bindParam(':idEvenement', $idEvent);
        $requete->execute();
        return $requete->fetchAll();
    }

    public function avisCheck($idEvent, $idUser)
    {
        $requete = $this->unPDO->prepare("SELECT COUNT(*) FROM avis 
        WHERE idUtilisateur = :idUtilisateur AND idEvenement = :idEvenement;");
        $requete->bindParam(':idEvenement', $idEvent);
        $requete->bindParam(':idUtilisateur', $idUser);
        $requete->execute();
        return $requete->fetchAll();
    }

    public function avgAvis($idEvent)
    {
        $requete = $this->unPDO->prepare("SELECT AVG(note) FROM avis
        WHERE idEvenement = :idEvenement");
        $requete->bindParam(':idEvenement', $idEvent);
        $requete->execute();
        return $requete->fetch();
    }
}
