-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 05, 2024 at 11:18 PM
-- Server version: 8.0.30
-- PHP Version: 7.4.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestionevenements`
--

-- --------------------------------------------------------

--
-- Table structure for table `centre_aere`
--

CREATE TABLE `centre_aere` (
  `idCentreAere` int NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `capacite` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `centre_aere`
--

INSERT INTO `centre_aere` (`idCentreAere`, `adresse`, `capacite`) VALUES
(1, '303 Rue de la Liberté', 50),
(2, '404 Rue des Peupliers', 60),
(3, '505 Chemin des Écoliers', 40);

-- --------------------------------------------------------

--
-- Table structure for table `evenement`
--

CREATE TABLE `evenement` (
  `idEvenement` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text,
  `date` datetime NOT NULL,
  `type` enum('Concert','Culturel','Educatif','Communautaire') NOT NULL,
  `statut` enum('en_attente','confirmé','annulé') NOT NULL,
  `organisateurId` int DEFAULT NULL,
  `lieuId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `evenement`
--

INSERT INTO `evenement` (`idEvenement`, `nom`, `description`, `date`, `type`, `statut`, `organisateurId`, `lieuId`) VALUES
(10, 'Festival musique', 'test', '2024-03-02 10:00:00', 'Concert', 'annulé', 11, 5),
(11, 'Meeting aérien', 'Pour illustrer la différence entre une procédure stockée et une fonction stockée, prenons un exemple simple basé sur une base de données fictive qui stocke des informations sur des employés. Nous allons créer une procédure stockée pour insérer un nouvel employé dans la base de données et une fonction stockée pour calculer l\'âge d\'un employé à partir de sa date de naissance.', '2024-03-15 13:00:00', 'Communautaire', 'confirmé', 28, 3),
(18, 'La route de la soif', 'alcool', '2024-03-07 02:14:00', 'Communautaire', 'confirmé', 11, 6);

--
-- Triggers `evenement`
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
-- Table structure for table `inscription_enfant`
--

CREATE TABLE `inscription_enfant` (
  `idEnfant` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `age` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inscription_enfant`
--

INSERT INTO `inscription_enfant` (`idEnfant`, `nom`, `prenom`, `age`) VALUES
(1, 'Durand', 'Tom', 8),
(2, 'Bernard', 'Léa', 10),
(3, 'Dubois', 'Maxime', 6),
(4, 'Morel', 'Clara', 7),
(5, 'Simon', 'Hugo', 9);

-- --------------------------------------------------------

--
-- Table structure for table `lieu`
--

CREATE TABLE `lieu` (
  `idLieu` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `capacite` int NOT NULL,
  `disponibilite` enum('disponible','réservé','indisponible') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lieu`
--

INSERT INTO `lieu` (`idLieu`, `nom`, `adresse`, `capacite`, `disponibilite`) VALUES
(2, 'Lieu 88', '456 Avenue des Fleurs', 67, 'indisponible'),
(3, 'Lieu 3', '789 Boulevard du Parc', 200, 'réservé'),
(4, 'Lieu 4', '101 Rue de la Gare', 150, 'disponible'),
(5, 'Lieu 5', '202 Avenue de la République', 400, 'réservé'),
(6, 'Lieu 69', '69 rue', 40, 'réservé');

-- --------------------------------------------------------

--
-- Table structure for table `organisateur`
--

CREATE TABLE `organisateur` (
  `idOrganisateur` int NOT NULL,
  `service` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `organisateur`
--

INSERT INTO `organisateur` (`idOrganisateur`, `service`) VALUES
(11, NULL),
(28, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `participant`
--

CREATE TABLE `participant` (
  `idParticipant` int NOT NULL,
  `dateinscription` datetime NOT NULL,
  `nbEnfants` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `participant`
--

INSERT INTO `participant` (`idParticipant`, `dateinscription`, `nbEnfants`) VALUES
(9, '2024-01-19 00:00:00', NULL),
(11, '2024-01-22 00:00:00', NULL),
(15, '2024-01-25 00:00:00', NULL),
(17, '2024-01-25 00:00:00', NULL),
(18, '2024-01-25 00:00:00', NULL),
(29, '2024-03-01 00:00:00', NULL),
(30, '2024-03-01 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `participation`
--

CREATE TABLE `participation` (
  `idParticipation` int NOT NULL,
  `idParticipant` int DEFAULT NULL,
  `dateinscription` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `nbenfants` int NOT NULL,
  `idEvenement` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `participation`
--

INSERT INTO `participation` (`idParticipation`, `idParticipant`, `dateinscription`, `nbenfants`, `idEvenement`) VALUES
(39, 28, '2024-03-01 09:40:47', 0, 11),
(42, 30, '2024-03-01 09:47:57', 0, 11),
(45, 11, '2024-03-05 23:16:53', 0, 11),
(46, 11, '2024-03-05 23:17:50', 0, 18);

--
-- Triggers `participation`
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

-- --------------------------------------------------------

--
-- Table structure for table `periode_scolaire`
--

CREATE TABLE `periode_scolaire` (
  `idPeriode` int NOT NULL,
  `datedebut` date NOT NULL,
  `datefin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `periode_scolaire`
--

INSERT INTO `periode_scolaire` (`idPeriode`, `datedebut`, `datefin`) VALUES
(1, '2024-09-01', '2024-10-31'),
(2, '2024-11-01', '2024-12-20'),
(3, '2025-01-04', '2025-02-28');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idUtilisateur` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `courriel` varchar(255) NOT NULL,
  `motdepasse` varchar(255) NOT NULL,
  `resetMDP` tinyint(1) DEFAULT NULL,
  `role` enum('organisateur','participant') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUtilisateur`, `nom`, `prenom`, `courriel`, `motdepasse`, `resetMDP`, `role`) VALUES
(9, 'Lopez', 'Manon', 'manon.lopez@email.com', 'password106', 1, 'participant'),
(11, 'Guerrand', 'Anthony', 'anthony.guerrand92@gmail.com', '$2y$10$VZ47sew1dcxwQ7cU2j.hsehMFM16846kMxKBDCEr3Y7eNqPNj.nkS', NULL, 'organisateur'),
(15, 'lourd', 'zark', 'z@gmail.com', '$2y$10$OzY4JlFJen1G0rNZOLvRgu0KCxzJ4aZRcZYdAd4.g1dLwlfjKFCrm', NULL, 'participant'),
(17, 'Guerrand', 'Dole', 'dole.guerrand92@gmail.com', '$2y$10$luig2wTqW38UP59aTzL7WuV.S0Kt9BhX96Fg5SoC54N7VbbCO0KdO', NULL, 'participant'),
(18, 'Guerrand', 'Anthony', 'anthony.guerrand2@gmail.com', '$2y$10$TAzI77e21LPAbIxthUICSOD5mdQR0ofsnu7FcZt0VNj/YlGH3gbVW', NULL, 'participant'),
(28, 'Yolo', 'Jean', 'jy@gmail.com', '$2y$10$mDPJWkc2EIbgTs1zoehAl.qmXr5C8kUWsxakal.ex/F5ZiFukBG2i', NULL, 'organisateur'),
(29, 'MICHEL', 'LOUIS', 'lm@gmail.com', '$2y$10$vxSdTvbFWgPxvC8T2A80RuNrMuZWIRqhI8fRMSekDbS2/jq82HTby', NULL, 'participant'),
(30, 'Ulm', 'Jack', 'ju@gmail.com', '$2y$10$Je/Z9uYAl0xra06gULuWq.7.j2RHHKH/.14CmpnsUcTTOwvE8BvAK', 0, 'participant');

--
-- Triggers `user`
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
        INSERT INTO organisateur (idOrganisateur, service) VALUES (NEW.idUtilisateur, NULL);
    ELSEIF NEW.role = 'participant' THEN
        INSERT INTO participant (idParticipant, dateinscription, nbEnfants) VALUES (NEW.idUtilisateur, CURDATE(), NULL);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_user` AFTER UPDATE ON `user` FOR EACH ROW BEGIN
    IF NEW.role != OLD.role THEN
      IF NEW.role = 'organisateur' THEN
          INSERT INTO organisateur (idOrganisateur, service) VALUES (NEW.idUtilisateur, NULL);
          DELETE FROM participant WHERE idParticipant = NEW.idUtilisateur;
      ELSEIF NEW.role = 'participant' THEN
          INSERT INTO participant (idParticipant, dateinscription, nbEnfants) VALUES (NEW.idUtilisateur, CURDATE(), NULL);
          DELETE FROM organisateur WHERE idOrganisateur = NEW.idUtilisateur;
      END IF;
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `centre_aere`
--
ALTER TABLE `centre_aere`
  ADD PRIMARY KEY (`idCentreAere`);

--
-- Indexes for table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`idEvenement`),
  ADD KEY `organisateurId` (`organisateurId`),
  ADD KEY `lieuId` (`lieuId`);

--
-- Indexes for table `inscription_enfant`
--
ALTER TABLE `inscription_enfant`
  ADD PRIMARY KEY (`idEnfant`);

--
-- Indexes for table `lieu`
--
ALTER TABLE `lieu`
  ADD PRIMARY KEY (`idLieu`);

--
-- Indexes for table `organisateur`
--
ALTER TABLE `organisateur`
  ADD PRIMARY KEY (`idOrganisateur`);

--
-- Indexes for table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`idParticipant`);

--
-- Indexes for table `participation`
--
ALTER TABLE `participation`
  ADD PRIMARY KEY (`idParticipation`),
  ADD KEY `idEvenement` (`idEvenement`);

--
-- Indexes for table `periode_scolaire`
--
ALTER TABLE `periode_scolaire`
  ADD PRIMARY KEY (`idPeriode`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD UNIQUE KEY `courriel` (`courriel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `centre_aere`
--
ALTER TABLE `centre_aere`
  MODIFY `idCentreAere` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `evenement`
--
ALTER TABLE `evenement`
  MODIFY `idEvenement` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `inscription_enfant`
--
ALTER TABLE `inscription_enfant`
  MODIFY `idEnfant` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lieu`
--
ALTER TABLE `lieu`
  MODIFY `idLieu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `participation`
--
ALTER TABLE `participation`
  MODIFY `idParticipation` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `periode_scolaire`
--
ALTER TABLE `periode_scolaire`
  MODIFY `idPeriode` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `idUtilisateur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `evenement_ibfk_1` FOREIGN KEY (`organisateurId`) REFERENCES `organisateur` (`idOrganisateur`),
  ADD CONSTRAINT `evenement_ibfk_2` FOREIGN KEY (`lieuId`) REFERENCES `lieu` (`idLieu`);

--
-- Constraints for table `organisateur`
--
ALTER TABLE `organisateur`
  ADD CONSTRAINT `organisateur_ibfk_1` FOREIGN KEY (`idOrganisateur`) REFERENCES `user` (`idUtilisateur`);

--
-- Constraints for table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `participant_ibfk_1` FOREIGN KEY (`idParticipant`) REFERENCES `user` (`idUtilisateur`);

--
-- Constraints for table `participation`
--
ALTER TABLE `participation`
  ADD CONSTRAINT `participation_ibfk_1` FOREIGN KEY (`idEvenement`) REFERENCES `evenement` (`idEvenement`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
