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
