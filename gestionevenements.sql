-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 21 mai 2024 à 00:07
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestionevenements`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `idAvis` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `idEvenement` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`idAvis`, `note`, `description`, `idEvenement`, `idUtilisateur`) VALUES
(4, 3, 'Moyen mais cool', 18, 11),
(16, 5, 'genial', 23, 11),
(17, 1, 'bzzzz', 22, 11),
(18, 5, 'yeeeeah', 18, 9),
(19, 4, 'bien', 21, 9);

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

CREATE TABLE `evenement` (
  `idEvenement` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date` datetime NOT NULL,
  `type` enum('Concert','Educatif','Communautaire','Autres') NOT NULL,
  `statut` enum('en_attente','confirmé','annulé','complet') NOT NULL,
  `organisateurId` int(11) DEFAULT NULL,
  `lieuId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `evenement`
--

INSERT INTO `evenement` (`idEvenement`, `nom`, `description`, `date`, `type`, `statut`, `organisateurId`, `lieuId`) VALUES
(18, 'La route de la soif', 'alcool', '2024-03-07 02:14:00', 'Communautaire', 'complet', 11, 6),
(21, 'test', 'test', '2024-03-02 10:00:00', 'Concert', 'en_attente', 11, 4),
(22, 'test3', 'test3', '2023-03-03 00:00:00', 'Concert', 'en_attente', 11, 7),
(23, 'test4', 'test4', '2023-03-03 00:00:00', 'Concert', 'en_attente', 49, 7),
(27, 'Meeting algerien', 'azerty', '2024-09-01 19:02:00', 'Educatif', 'en_attente', 11, 28);

--
-- Déclencheurs `evenement`
--
DELIMITER $$
CREATE TRIGGER `delete_participation` BEFORE DELETE ON `evenement` FOR EACH ROW BEGIN
    DELETE FROM participation WHERE idEvenement = OLD.idEvenement;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_participation2` AFTER UPDATE ON `evenement` FOR EACH ROW BEGIN 
    IF NEW.statut = 'annulé' THEN
        DELETE FROM participation WHERE idEvenement = NEW.idEvenement;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_lieu_state` AFTER INSERT ON `evenement` FOR EACH ROW BEGIN
  UPDATE lieu SET disponibilite = 'réservé' WHERE idLieu = NEW.lieuId;
  
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_lieu_state2` BEFORE DELETE ON `evenement` FOR EACH ROW BEGIN
  UPDATE lieu SET disponibilite = 'disponible' WHERE idLieu = OLD.lieuId;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

CREATE TABLE `lieu` (
  `idLieu` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `adresse` varchar(30) NOT NULL,
  `capacite` varchar(20) NOT NULL,
  `disponibilite` enum('disponible','réservé','indisponible') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `lieu`
--

INSERT INTO `lieu` (`idLieu`, `nom`, `adresse`, `capacite`, `disponibilite`) VALUES
(3, 'Lieu 3', '789 Boulevard du Parc', '200', 'réservé'),
(4, 'Lieu 4', '101 Rue de la Gare', '150', 'réservé'),
(5, 'Lieu 5', '202 Avenue de la République', '400', 'réservé'),
(6, 'Lieu 69', '69 rue', '2', 'réservé'),
(7, 'Parc des grands', 'Boulevard 69', '300', 'réservé'),
(28, 'test2', 'test2', '50', 'réservé'),
(29, 'test2', 'test2', '50', 'disponible'),
(30, 'test3', 'test3', 'test3', 'indisponible'),
(32, 'Salle 44', '28 rue moliere', '15', 'disponible');

-- --------------------------------------------------------

--
-- Structure de la table `organisateur`
--

CREATE TABLE `organisateur` (
  `idOrganisateur` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `service` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `organisateur`
--

INSERT INTO `organisateur` (`idOrganisateur`, `nom`, `prenom`, `service`) VALUES
(11, 'Guerrand', 'Anthony', NULL),
(28, 'Yolo', 'Jean', NULL),
(31, 'Migro', 'Timoté', NULL),
(49, 'test9', 'test9', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

CREATE TABLE `participant` (
  `idParticipant` int(11) NOT NULL,
  `dateinscription` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `participant`
--

INSERT INTO `participant` (`idParticipant`, `dateinscription`) VALUES
(9, '2024-01-19 00:00:00'),
(11, '2024-01-22 00:00:00'),
(15, '2024-01-25 00:00:00'),
(29, '2024-03-01 00:00:00'),
(47, '2024-04-08 00:00:00'),
(48, '2024-04-08 00:00:00'),
(50, '2024-04-08 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `participation`
--

CREATE TABLE `participation` (
  `idParticipation` int(11) NOT NULL,
  `idParticipant` int(11) DEFAULT NULL,
  `dateinscription` timestamp NULL DEFAULT current_timestamp(),
  `idEvenement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `participation`
--

INSERT INTO `participation` (`idParticipation`, `idParticipant`, `dateinscription`, `idEvenement`) VALUES
(54, 33, '2024-04-04 08:22:07', 18),
(56, 9, '2024-05-20 15:54:27', 18);

--
-- Déclencheurs `participation`
--
DELIMITER $$
CREATE TRIGGER `check_participation` BEFORE INSERT ON `participation` FOR EACH ROW BEGIN
    DECLARE existingCount INT;

    SELECT COUNT(*)
    INTO existingCount
    FROM participation
    WHERE idParticipant = NEW.idParticipant AND idEvenement = NEW.idEvenement;

    IF existingCount > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = "L'utilisateur est déjà inscrit.";
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `isEventFull` AFTER INSERT ON `participation` FOR EACH ROW BEGIN
    DECLARE capacite INT;
    DECLARE nombre_inscris INT;

    SELECT lieu.capacite INTO capacite
    FROM evenement
    JOIN lieu ON evenement.lieuId = lieu.idLieu
    WHERE idEvenement = NEW.idEvenement;

    SELECT COUNT(*) INTO nombre_inscris
    FROM participation
    WHERE idEvenement = NEW.idEvenement;

    IF nombre_inscris >= capacite THEN
        UPDATE evenement SET statut = 'complet' WHERE idEvenement = NEW.idEvenement;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `isEventFull2` AFTER DELETE ON `participation` FOR EACH ROW BEGIN
    DECLARE currentStatus VARCHAR(100);

    SELECT statut INTO currentStatus FROM evenement
    WHERE idEvenement = OLD.idEvenement;

    IF currentStatus = 'complet' THEN
        UPDATE evenement SET statut = 'confirmé'
        WHERE idEvenement = OLD.idEvenement;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `idUtilisateur` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `courriel` varchar(255) NOT NULL,
  `motdepasse` varchar(255) NOT NULL,
  `resetMDP` tinyint(1) DEFAULT NULL,
  `role` enum('organisateur','participant') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUtilisateur`, `nom`, `prenom`, `courriel`, `motdepasse`, `resetMDP`, `role`) VALUES
(9, 'Lopez', 'Manon', 'manonlopez@email.com', 'root2', 0, 'participant'),
(11, 'Guerrand', 'Anthony', 'anthony.guerrand92@gmail.com', 'root', NULL, 'organisateur'),
(15, 'lourd', 'zark', 'z@gmail.com', '$2y$10$OzY4JlFJen1G0rNZOLvRgu0KCxzJ4aZRcZYdAd4.g1dLwlfjKFCrm', NULL, 'participant'),
(28, 'Yolo', 'Jean', 'jy@gmail.com', '$2y$10$mDPJWkc2EIbgTs1zoehAl.qmXr5C8kUWsxakal.ex/F5ZiFukBG2i', NULL, 'organisateur'),
(29, 'MICHEL', 'LOUIS', 'lm@gmail.com', '$2y$10$vxSdTvbFWgPxvC8T2A80RuNrMuZWIRqhI8fRMSekDbS2/jq82HTby', NULL, 'participant'),
(31, 'Migro', 'Timoté', 'tm@gmail.com', 'root', 0, 'organisateur'),
(47, 'test7', 'test7', 'test7', 'test7', 0, 'participant'),
(48, 'test8', 'test8', 'test8', 'test8', 0, 'participant'),
(49, 'test9', 'test9', 'test9', 'test9', 0, 'organisateur'),
(50, 'test', 'test', 'test', 'test', 0, 'participant');

--
-- Déclencheurs `user`
--
DELIMITER $$
CREATE TRIGGER `check_email` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
    DECLARE email_count INT;

    SELECT COUNT(*) INTO email_count FROM User WHERE courriel = NEW.courriel;

    IF email_count > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Cet email est déjà utilisé';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `check_email_insert` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
    DECLARE email_count INT;
    SELECT COUNT(*) INTO email_count FROM User WHERE courriel = NEW.courriel;
    IF email_count > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Cet email est déjà utilisé';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `check_email_update` BEFORE UPDATE ON `user` FOR EACH ROW BEGIN
    DECLARE email_count INT;
    SELECT COUNT(*) INTO email_count FROM User WHERE courriel = NEW.courriel AND idUtilisateur != NEW.idUtilisateur;
    IF email_count > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Cet email est déjà utilisé';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_user` BEFORE DELETE ON `user` FOR EACH ROW BEGIN
    DELETE FROM organisateur WHERE idOrganisateur = OLD.idUtilisateur;
    DELETE FROM participant WHERE idParticipant = OLD.idUtilisateur;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_user` AFTER INSERT ON `user` FOR EACH ROW BEGIN
    IF NEW.role = 'organisateur' THEN
        INSERT IGNORE INTO organisateur (idOrganisateur, nom, prenom, service) 
        VALUES (NEW.idUtilisateur, NEW.nom, NEW.prenom, NULL);
    ELSEIF NEW.role = 'participant' THEN
        INSERT IGNORE INTO participant (idParticipant, dateinscription) 
        VALUES (NEW.idUtilisateur, CURDATE());
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_user` AFTER UPDATE ON `user` FOR EACH ROW BEGIN
    IF NEW.role != OLD.role THEN
        IF NEW.role = 'organisateur' THEN
            INSERT INTO organisateur (idOrganisateur, nom, prenom, service) 
            VALUES (NEW.idUtilisateur, NEW.nom, NEW.prenom, NULL)
            ON DUPLICATE KEY UPDATE nom = VALUES(nom), prenom = VALUES(prenom), service = VALUES(service);
            DELETE FROM participant WHERE idParticipant = NEW.idUtilisateur;
        ELSEIF NEW.role = 'participant' THEN
            INSERT INTO participant (idParticipant, dateinscription) 
            VALUES (NEW.idUtilisateur, CURDATE(), NULL)
            ON DUPLICATE KEY UPDATE dateinscription = VALUES(dateinscription);
            DELETE FROM organisateur WHERE idOrganisateur = NEW.idUtilisateur;
        END IF;
    END IF;
END
$$
DELIMITER ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`idAvis`),
  ADD KEY `fk_evenement` (`idEvenement`),
  ADD KEY `idUtilisateur` (`idUtilisateur`);

--
-- Index pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`idEvenement`),
  ADD KEY `organisateurId` (`organisateurId`),
  ADD KEY `lieuId` (`lieuId`);

--
-- Index pour la table `lieu`
--
ALTER TABLE `lieu`
  ADD PRIMARY KEY (`idLieu`);

--
-- Index pour la table `organisateur`
--
ALTER TABLE `organisateur`
  ADD PRIMARY KEY (`idOrganisateur`);

--
-- Index pour la table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`idParticipant`);

--
-- Index pour la table `participation`
--
ALTER TABLE `participation`
  ADD PRIMARY KEY (`idParticipation`),
  ADD KEY `idEvenement` (`idEvenement`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD UNIQUE KEY `courriel` (`courriel`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `idAvis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `evenement`
--
ALTER TABLE `evenement`
  MODIFY `idEvenement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `lieu`
--
ALTER TABLE `lieu`
  MODIFY `idLieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `participation`
--
ALTER TABLE `participation`
  MODIFY `idParticipation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `user` (`idUtilisateur`),
  ADD CONSTRAINT `fk_evenement` FOREIGN KEY (`idEvenement`) REFERENCES `evenement` (`idEvenement`) ON DELETE CASCADE;

--
-- Contraintes pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `evenement_ibfk_1` FOREIGN KEY (`organisateurId`) REFERENCES `organisateur` (`idOrganisateur`),
  ADD CONSTRAINT `evenement_ibfk_2` FOREIGN KEY (`lieuId`) REFERENCES `lieu` (`idLieu`);

--
-- Contraintes pour la table `organisateur`
--
ALTER TABLE `organisateur`
  ADD CONSTRAINT `organisateur_ibfk_1` FOREIGN KEY (`idOrganisateur`) REFERENCES `user` (`idUtilisateur`);

--
-- Contraintes pour la table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `participant_ibfk_1` FOREIGN KEY (`idParticipant`) REFERENCES `user` (`idUtilisateur`);

--
-- Contraintes pour la table `participation`
--
ALTER TABLE `participation`
  ADD CONSTRAINT `participation_ibfk_1` FOREIGN KEY (`idEvenement`) REFERENCES `evenement` (`idEvenement`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
