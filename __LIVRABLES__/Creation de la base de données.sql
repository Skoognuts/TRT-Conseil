-- DATABASE CREATION --
CREATE DATABASE IF NOT EXISTS xzedm5a4pmokd5el CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- TABLES CREATION --
DROP TABLE IF EXISTS administrator;
DROP TABLE IF EXISTS candidate;
DROP TABLE IF EXISTS consultant;
DROP TABLE IF EXISTS job_application;
DROP TABLE IF EXISTS job_offer;
DROP TABLE IF EXISTS recruiter;
DROP TABLE IF EXISTS user;

CREATE TABLE user (
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  email varchar(180) NOT NULL UNIQUE,
  password varchar(255) NOT NULL,
  is_approved boolean NOT NULL,
  user_type int(11) NOT NULL,
  roles longtext NOT NULL COMMENT '(DC2Type:json)'
) ENGINE=InnoDB;

CREATE TABLE administrator (
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL UNIQUE,
  first_name varchar(255) NOT NULL,
  last_name varchar(255) NOT NULL,
  CONSTRAINT is_administrator
    FOREIGN KEY (user_id)
    REFERENCES user(id)
) ENGINE=InnoDB;

CREATE TABLE candidate (
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL UNIQUE,
  first_name varchar(255) NOT NULL,
  last_name varchar(255) NOT NULL,
  cv varchar(255) NOT NULL,
  CONSTRAINT is_candidate
    FOREIGN KEY (user_id)
    REFERENCES user(id)
) ENGINE=InnoDB;

CREATE TABLE consultant (
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL UNIQUE,
  first_name varchar(255) NOT NULL,
  last_name varchar(255) NOT NULL,
  CONSTRAINT is_consultant
    FOREIGN KEY (user_id)
    REFERENCES user(id)
) ENGINE=InnoDB;

CREATE TABLE recruiter (
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL UNIQUE,
  company varchar(255) NOT NULL,
  address varchar(255) NOT NULL,
  CONSTRAINT is_recruiter
    FOREIGN KEY (user_id)
    REFERENCES user(id)
) ENGINE=InnoDB;

CREATE TABLE job_offer (
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  company_id int(11) NOT NULL,
  title varchar(255) NOT NULL,
  description longtext NOT NULL,
  is_approved boolean NOT NULL,
  CONSTRAINT has_company
    FOREIGN KEY (company_id)
    REFERENCES recruiter(id)
) ENGINE=InnoDB;

CREATE TABLE job_application (
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  candidate_id int(11) NOT NULL,
  job_offer_id int(11) NOT NULL,
  is_approved boolean NOT NULL,
  CONSTRAINT has_candidate
    FOREIGN KEY (candidate_id)
    REFERENCES candidate(id),
  CONSTRAINT has_job_offer
    FOREIGN KEY (job_offer_id)
    REFERENCES job_offer(id)
) ENGINE=InnoDB;

-- TABLES FILLING FUNCTIONS --
INSERT INTO `user`(`id`, `email`, `roles`, `password`, `is_approved`, `user_type`) VALUES (1, 'admin@trt-conseil.fr', '["ROLE_ADMINISTRATOR"]', '$2y$13$ru8BJQmaUL/q/KLMABY/Iepv3TE7RAaLlOzoRYywQL8TG1oaMmYvO', 1, 1);
INSERT INTO `user`(`id`, `email`, `roles`, `password`, `is_approved`, `user_type`) VALUES (2, 'jm-martin@trt-conseil.fr', '["ROLE_CONSULTANT"]', '$2y$13$nEN/vChOXMCg6adR6bOs/Oh3Z8WaCkeeDPc5.hEMRNhtAzIlm93QC', 1, 2);
INSERT INTO `user`(`id`, `email`, `roles`, `password`, `is_approved`, `user_type`) VALUES (3, 'jj-dupont@trt-conseil.fr', '["ROLE_CONSULTANT"]', '$2y$13$jRs0UQ4g9axr5xgKP6JarO1xd9CInvitzl0T84jENUCk0ERVEzht.', 1, 2);
INSERT INTO `user`(`id`, `email`, `roles`, `password`, `is_approved`, `user_type`) VALUES (4, 'rh@btp-france.fr', '["ROLE_RECRUITER"]', '$2y$13$KbLH2gjlClZn/ADQWphhueMHPBtd8Wj8bNn1VKAIeFiy5XCG3n2he', 1, 3);
INSERT INTO `user`(`id`, `email`, `roles`, `password`, `is_approved`, `user_type`) VALUES (5, 'rh@dev-zone.fr', '["ROLE_RECRUITER"]', '$2y$13$bDp/zUqHOYDq6M4Pl3K8S.ydqQASyK9LV7J0k5k1MQC.WP9dhzu.m', 1, 3);
INSERT INTO `user`(`id`, `email`, `roles`, `password`, `is_approved`, `user_type`) VALUES (6, 'rh@la-banque.fr', '["ROLE_RECRUITER"]', '$2y$13$mU6wdqKKfvjww8sfJZ3Bt.EyBMs4ztSYZPnMqJb.KULxdIe3k90RS', 1, 3);
INSERT INTO `user`(`id`, `email`, `roles`, `password`, `is_approved`, `user_type`) VALUES (7, 'rh@brico.fr', '["ROLE_UNAUTHORIZED"]', '$2y$13$j2EDiLka4KWXu5/QDAXV0OPHunA2YEf9wQDGaMO0U6yNJ2aeisJ6W', 0, 3);
INSERT INTO `user`(`id`, `email`, `roles`, `password`, `is_approved`, `user_type`) VALUES (8, 'rh@boulangerie.fr', '["ROLE_UNAUTHORIZED"]', '$2y$13$9qJbLf1QIuZaB06cM87SV.TYhWnJBgTQqMDuFRPNOVkX1sLOkDHKK', 0, 3);
INSERT INTO `user`(`id`, `email`, `roles`, `password`, `is_approved`, `user_type`) VALUES (9, 'jean-bombeur@gmail.com', '["ROLE_CANDIDATE"]', '$2y$13$JqYY5cV75C4H7126g98Nx.AzpYHAtlNGgE9tBNYz1lT9MfAloabZa', 1, 4);
INSERT INTO `user`(`id`, `email`, `roles`, `password`, `is_approved`, `user_type`) VALUES (10, 'jacques-langue@gmail.com', '["ROLE_CANDIDATE"]', '$2y$13$Yndysal2acqmauzdReY42eOaUikBn65kphkk3QcqqdJGPHU53NC06', 1, 4);
INSERT INTO `user`(`id`, `email`, `roles`, `password`, `is_approved`, `user_type`) VALUES (11, 'estelle-lefemur@gmail.com', '["ROLE_CANDIDATE"]', '$2y$13$ctccqpYg2kjeiaG1KOVjE.HlGcMM76qb9zK/8bznnkzWHvPm/rag2', 1, 4);
INSERT INTO `user`(`id`, `email`, `roles`, `password`, `is_approved`, `user_type`) VALUES (12, 'lucie-liu@gmail.com', '["ROLE_UNAUTHORIZED"]', '$2y$13$.zfgUfQ40oIg7gqAefO/BuW6Usx8t2qfjTkpJQ3c08VSKUoemnNiy', 0, 4);
INSERT INTO `user`(`id`, `email`, `roles`, `password`, `is_approved`, `user_type`) VALUES (13, 'georges-delajungle@gmail.com', '["ROLE_UNAUTHORIZED"]', '$2y$13$gLQb4fOBxXg.FwfS4czg1.s/dzRKTIoZ8nrpOhEkqr/oPmxPeShrC', 0, 4);

INSERT INTO `administrator`(`id`, `user_id`, `first_name`, `last_name`) VALUES (1, 1, 'Julien', 'LABATUT');

INSERT INTO `consultant`(`id`, `user_id`, `first_name`, `last_name`) VALUES (1, 2, 'Jean-Marc', 'MARTIN');
INSERT INTO `consultant`(`id`, `user_id`, `first_name`, `last_name`) VALUES (2, 3, 'Jean-Jacques', 'DUPONT');

INSERT INTO `recruiter`(`id`, `user_id`, `company`, `address`) VALUES (1, 4, 'BTP France', '25 Avenue de la Truelle, 33140 Nouillorc');
INSERT INTO `recruiter`(`id`, `user_id`, `company`, `address`) VALUES (2, 5, 'Dev Zone', '50 Bis Impasse du Point Virgule, 01001 Error-City');

INSERT INTO `candidate`(`id`, `user_id`, `first_name`, `last_name`, `cv`) VALUES (1, 9, 'Jean', 'BOMBEUR', 'CV-JBombeur-63319828c3839.pdf');
INSERT INTO `candidate`(`id`, `user_id`, `first_name`, `last_name`, `cv`) VALUES (2, 10, 'Jacques', 'LANGUE', 'CV-JLangue-6331986d25cd4.pdf');

INSERT INTO `job_offer`(`id`, `company_id`, `title`, `description`, `is_approved`) VALUES (1, 1, 'C.D.I Carreleur', 'Recherche amateur de puzzle pour recouvrir une surface de 7000m² avec de la mosaïque.', 1);
INSERT INTO `job_offer`(`id`, `company_id`, `title`, `description`, `is_approved`) VALUES (2, 1, 'C.D.D Plaquiste', 'Recherche plaquiste qualifié pour couvrir une maison en forme de sphère.', 1);
INSERT INTO `job_offer`(`id`, `company_id`, `title`, `description`, `is_approved`) VALUES (3, 1, 'C.D.D Electricien', 'Recherche artisan qualifié pour venir brancher la prise de mon aspirateur.', 0);
INSERT INTO `job_offer`(`id`, `company_id`, `title`, `description`, `is_approved`) VALUES (4, 1, 'C.D.I Chauffagiste', 'Recherche chauffagiste débutant pour la pose d''un système de refroidissement dans une centrale nucléaire.', 0);
INSERT INTO `job_offer`(`id`, `company_id`, `title`, `description`, `is_approved`) VALUES (5, 2, 'C.D.I Développeur Front-End', 'Recherche développeur junior avec 25 ans d''expérience en HTML.', 1);
INSERT INTO `job_offer`(`id`, `company_id`, `title`, `description`, `is_approved`) VALUES (6, 2, 'C.D.D Développeur Back-End', 'Recherche jeune bénévole pour administrer la base de données de notre multinationale.', 1);
INSERT INTO `job_offer`(`id`, `company_id`, `title`, `description`, `is_approved`) VALUES (7, 2, 'C.D.D Gestionnaire Réseau', 'Au secours !!! On a des câbles partout !!', 0);
INSERT INTO `job_offer`(`id`, `company_id`, `title`, `description`, `is_approved`) VALUES (8, 2, 'C.D.I Ressources Humaines', 'Recherche responsable R.H. pour remplacer l''ancien qui était un peu zinzin avec les offres d''emploi.', 0);

INSERT INTO `job_application`(`id`, `candidate_id`, `job_offer_id`, `is_approved`) VALUES (1, 1, 1, 1);
INSERT INTO `job_application`(`id`, `candidate_id`, `job_offer_id`, `is_approved`) VALUES (2, 1, 2, 0);
INSERT INTO `job_application`(`id`, `candidate_id`, `job_offer_id`, `is_approved`) VALUES (3, 1, 5, 1);
INSERT INTO `job_application`(`id`, `candidate_id`, `job_offer_id`, `is_approved`) VALUES (4, 1, 6, 0);
INSERT INTO `job_application`(`id`, `candidate_id`, `job_offer_id`, `is_approved`) VALUES (5, 2, 1, 1);
INSERT INTO `job_application`(`id`, `candidate_id`, `job_offer_id`, `is_approved`) VALUES (6, 2, 5, 0);
INSERT INTO `job_application`(`id`, `candidate_id`, `job_offer_id`, `is_approved`) VALUES (7, 2, 6, 1);