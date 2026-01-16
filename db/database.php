<?php
    class Database {
        private $db;
        
        private function getUser(string $username): array {
            $query = "SELECT id, password, ruolo FROM utenti WHERE email = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("s", $username);

            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function __construct($host, $username, $password, $database, $port) {
            $this->db = new mysqli($host, $username, $password, $database, $port);
        }

        /**
         * Returns the user information
         * @param string $username user's username
         * @param string $password user's password
         * @return array Array containing the user information
         */
        public function checkLogin(string $username, string $password): array {
            $user = $this->getUser($username);

            if (password_verify($password, password_hash($password, PASSWORD_DEFAULT))) {
                return $user;
            } else {
                return array();
            }
        }

        public function registerUser(string $username, string $password): void {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
            $query = "INSERT INTO utenti (email, password) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ss", $username, $password_hash);

            $stmt->execute();
        }

        public function insertOggetto($nome, $categoria, $luogo, $data, $foto) {
            $query = "INSERT INTO oggetti_ritrovati (nome, categoria, luogo, data_ritrovamento, foto) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            if (!$stmt) return false; 
            
            $stmt->bind_param("sssss", $nome, $categoria, $luogo, $data, $foto);
            return $stmt->execute();
    }
    }
?>