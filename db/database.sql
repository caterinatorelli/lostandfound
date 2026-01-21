CREATE DATABASE IF NOT EXISTS campus_oggetti_smarriti;
USE campus_oggetti_smarriti;

CREATE TABLE IF NOT EXISTS utenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    ruolo ENUM('admin','fruitore') DEFAULT 'fruitore' NOT NULL
);

CREATE TABLE IF NOT EXISTS oggetti_ritrovati (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    categoria ENUM('Elettronica','Vestiti','Materiale scolastico','Altro') NOT NULL,
    luogo VARCHAR(255) NOT NULL,
    data_ritrovamento DATE NOT NULL,
    foto VARCHAR(255),
    id_inseritore INT,
    data_inserimento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    stato ENUM('pending', 'approved', 'refused', 'restituito') DEFAULT 'pending' NOT NULL
);

CREATE TABLE IF NOT EXISTS richieste (
    id INT AUTO_INCREMENT PRIMARY KEY,
    oggetto_id INT NOT NULL,
    richiedente_id INT NOT NULL,
    messaggio TEXT,
    stato ENUM('pending','accettata','rifiutata') DEFAULT 'pending',
    creato TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);