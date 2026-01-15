-- Creazione del Database
CREATE DATABASE IF NOT EXISTS campus_oggetti_smarriti;
USE campus_oggetti_smarriti;

-- Tabella Utenti (per Login e Registrazione)
CREATE TABLE utenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, 
    ruolo ENUM('admin', 'fruitore') DEFAULT 'fruitore',
    nome VARCHAR(100)
);

-- Tabella Oggetti (per CRUD Admin e Fruizione Servizio)
CREATE TABLE oggetti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    descrizione TEXT,
    categoria VARCHAR(100),
    luogo VARCHAR(255),
    data_ritrovamento DATE,
    stato ENUM('disponibile', 'restituito') DEFAULT 'disponibile',
    id_inseritore INT,
    FOREIGN KEY (id_inseritore) REFERENCES utenti(id) ON DELETE SET NULL
);