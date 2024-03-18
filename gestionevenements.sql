-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2024 at 11:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
-- Table structure for table `evenement`
--

CREATE TABLE `evenement` (
  `idEvenement` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date` datetime NOT NULL,
  `type` enum('Concert','Educatif','Communautaire') NOT NULL,
  `statut` enum('en_attente','confirmé','annulé') NOT NULL,
  `organisateurId` int(11) DEFAULT NULL,
  `lieuId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evenement`
--

INSERT INTO `evenement` (`idEvenement`, `nom`, `description`, `date`, `type`, `statut`, `organisateurId`, `lieuId`) VALUES
(10, 'Festival musique', 'test', '2024-03-02 10:00:00', 'Concert', 'annulé', 11, 5),
(11, 'Meeting aérien', 'Pour illustrer la différence entre une procédure stockée et une fonction stockée, prenons un exemple simple basé sur une base de données fictive qui stocke des informations sur des employés. Nous allons créer une procédure stockée pour insérer un nouvel employé dans la base de données et une fonction stockée pour calculer l\'âge d\'un employé à partir de sa date de naissance.', '2024-03-15 13:00:00', 'Communautaire', 'confirmé', 28, 3),
(18, 'La route de la soif', 'alcool', '2024-03-07 02:14:00', 'Communautaire', 'confirmé', 11, 6),
(19, 'test', 'test', '2024-03-24 17:21:00', 'Concert', 'confirmé', 11, 4),
(20, 'Combat doumbe', 'ufc', '2024-03-20 02:29:00', 'Educatif', 'en_attente', 11, 7);

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
-- Table structure for table `lieu`
--

CREATE TABLE `lieu` (
  `idLieu` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `capacite` int(11) NOT NULL,
  `disponibilite` enum('disponible','réservé','indisponible') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lieu`
--

INSERT INTO `lieu` (`idLieu`, `nom`, `adresse`, `capacite`, `disponibilite`) VALUES
(2, 'Lieu 88', '456 Avenue des Fleurs', 67, 'indisponible'),
(3, 'Lieu 3', '789 Boulevard du Parc', 200, 'réservé'),
(4, 'Lieu 4', '101 Rue de la Gare', 150, 'réservé'),
(5, 'Lieu 5', '202 Avenue de la République', 400, 'réservé'),
(6, 'Lieu 69', '69 rue', 40, 'réservé'),
(7, 'Parc des grands', 'Boulevard 69', 300, 'réservé'),
(10, 'Gymnase leo lagrange', 'avenue gambetta', 800, 'indisponible');

-- --------------------------------------------------------

--
-- Table structure for table `organisateur`
--

CREATE TABLE `organisateur` (
  `idOrganisateur` int(11) NOT NULL,
  `service` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `idParticipant` int(11) NOT NULL,
  `dateinscription` datetime NOT NULL,
  `nbEnfants` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(30, '2024-03-01 00:00:00', NULL),
(31, '2024-03-14 00:00:00', NULL),
(32, '2024-03-15 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `participation`
--

CREATE TABLE `participation` (
  `idParticipation` int(11) NOT NULL,
  `idParticipant` int(11) DEFAULT NULL,
  `dateinscription` timestamp NULL DEFAULT current_timestamp(),
  `nbenfants` int(11) NOT NULL,
  `idEvenement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participation`
--

INSERT INTO `participation` (`idParticipation`, `idParticipant`, `dateinscription`, `nbenfants`, `idEvenement`) VALUES
(39, 28, '2024-03-01 09:40:47', 0, 11),
(42, 30, '2024-03-01 09:47:57', 0, 11),
(48, 11, '2024-03-06 23:28:49', 0, 18),
(49, 11, '2024-03-07 13:11:09', 0, 19),
(50, 31, '2024-03-14 08:53:50', 0, 11);

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
-- Table structure for table `user`
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
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUtilisateur`, `nom`, `prenom`, `courriel`, `motdepasse`, `resetMDP`, `role`) VALUES
(9, 'Lopez', 'Manon', 'manon.lopez@email.com', 'password106', 1, 'participant'),
(11, 'Guerrand', 'Anthony', 'anthony.guerrand92@gmail.com', 'root', NULL, 'organisateur'),
(15, 'lourd', 'zark', 'z@gmail.com', '$2y$10$OzY4JlFJen1G0rNZOLvRgu0KCxzJ4aZRcZYdAd4.g1dLwlfjKFCrm', NULL, 'participant'),
(17, 'Guerrand', 'Dole', 'dole.guerrand92@gmail.com', '$2y$10$luig2wTqW38UP59aTzL7WuV.S0Kt9BhX96Fg5SoC54N7VbbCO0KdO', NULL, 'participant'),
(18, 'Guerrand', 'Anthony', 'anthony.guerrand2@gmail.com', '$2y$10$TAzI77e21LPAbIxthUICSOD5mdQR0ofsnu7FcZt0VNj/YlGH3gbVW', NULL, 'participant'),
(28, 'Yolo', 'Jean', 'jy@gmail.com', '$2y$10$mDPJWkc2EIbgTs1zoehAl.qmXr5C8kUWsxakal.ex/F5ZiFukBG2i', NULL, 'organisateur'),
(29, 'MICHEL', 'LOUIS', 'lm@gmail.com', '$2y$10$vxSdTvbFWgPxvC8T2A80RuNrMuZWIRqhI8fRMSekDbS2/jq82HTby', NULL, 'participant'),
(30, 'Ulm', 'Jack', 'ju@gmail.com', '$2y$10$Je/Z9uYAl0xra06gULuWq.7.j2RHHKH/.14CmpnsUcTTOwvE8BvAK', 0, 'participant'),
(31, 'Migro', 'Timoté', 'tm@gmail.com', 'root', 0, 'participant'),
(32, 'lala', 'lolo', 'lala@gmail.com', 'lala', NULL, 'participant');

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
-- Indexes for table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`idEvenement`),
  ADD KEY `organisateurId` (`organisateurId`),
  ADD KEY `lieuId` (`lieuId`);

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
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD UNIQUE KEY `courriel` (`courriel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `evenement`
--
ALTER TABLE `evenement`
  MODIFY `idEvenement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `lieu`
--
ALTER TABLE `lieu`
  MODIFY `idLieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `participation`
--
ALTER TABLE `participation`
  MODIFY `idParticipation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
