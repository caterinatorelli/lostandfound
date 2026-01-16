-- Creazione del Database
CREATE DATABASE IF NOT EXISTS campus_oggetti_smarriti
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE campus_oggetti_smarriti;

-- Tabella Utenti (per Login e Registrazione)
CREATE TABLE IF NOT EXISTS utenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, 
    ruolo ENUM('admin', 'fruitore') DEFAULT 'fruitore',
    nome VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabella Oggetti (per CRUD Admin e Fruizione Servizio)
CREATE TABLE IF NOT EXISTS oggetti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    descrizione TEXT,
    categoria VARCHAR(100),
    luogo VARCHAR(255),
    data_ritrovamento DATE,
    stato ENUM('disponibile', 'restituito') DEFAULT 'disponibile',
    id_inseritore INT,
    FOREIGN KEY (id_inseritore) REFERENCES utenti(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS oggetti_ritrovati (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    categoria ENUM('Elettronica', 'Vestiti', 'Materiale scolastico', 'Altro') NOT NULL,
    luogo VARCHAR(255) NOT NULL,
    data_ritrovamento DATE NOT NULL,
    foto VARCHAR(255) DEFAULT NULL,
    id_inseritore INT DEFAULT NULL,
    data_inserimento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_inseritore) REFERENCES utenti(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;