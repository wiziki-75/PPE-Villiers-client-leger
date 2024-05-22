<?php
class lieu extends BDD
{
    function selectAllLieu()
    {
        $requete = "SELECT * FROM lieu;";
        $select = $this->unPDO->query($requete);
        return $select->fetchAll();
    }

    public function selectLieu($id)
    {
        $requete = $this->unPDO->prepare("SELECT * FROM lieu WHERE idLieu = :id;");
        $requete->bindParam(':id', $id);
        $requete->execute();
        return $requete->fetch();
    }

    public function addLieu($tab)
    {
        try {
            $requete = $this->unPDO->prepare("INSERT INTO lieu (nom, adresse, capacite, disponibilite) 
            VALUES (:nom, :adresse, :capacite, :disponibilite);");

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

    public function updateLieu($tab)
    {
        try {
            $id = $tab['idLieu'];
            unset($tab['idLieu']); // Retirer l'identifiant du tableau pour éviter de le mettre à jour

            $sql = "UPDATE lieu SET ";

            $setParts = [];
            foreach ($tab as $param => $value) {
                $setParts[] = "$param = :$param";
            }
            $sql .= implode(', ', $setParts);

            $sql .= " WHERE idLieu = :idLieu;";

            $requete = $this->unPDO->prepare($sql);

            foreach ($tab as $param => $value) {
                $requete->bindValue(':' . $param, $value);
            }

            $requete->bindValue(':idLieu', $id);
            $requete->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour : " . $e->getMessage();
            return false;
        }
    }

    function lieuState($id, $state)
    {
        try {
            $requete = $this->unPDO->prepare("UPDATE lieu SET disponibilite = :state WHERE idLieu = :id");
            $requete->bindParam(':state', $state);
            $requete->bindParam(':id', $id);
            $requete->execute();

            if ($requete->rowCount() > 0) {
                return true;
            } else {
                return "Aucune modification effectuée. Vérifiez l'ID du lieu.";
            }
        } catch (PDOException $e) {
            error_log("Erreur lors de la modification de la disponibilité du lieu : " . $e->getMessage());
            return "Erreur lors de la modification de la disponibilité du lieu.";
        }
    }

    public function deleteLieu($id)
    {
        try {
            $requete = $this->unPDO->prepare("DELETE FROM lieu WHERE idlieu = :id");
            $requete->bindParam(':id', $id);
            $requete->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
