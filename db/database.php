<?php
    class Database {
        private $db;
        
        private function getUser(string $username): array {
            $query = "SELECT id, email, password, ruolo FROM utenti WHERE email = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("s", $username);

            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC)[0];
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

        // New methods for the "search objects" page and to create "It's mine" requests
        /**
         * Returns the reported objects (oggetti_ritrovati) with inserter info if present
         * @return array
         */
        public function getFoundObjects(): array {
            $query = "SELECT o.*, u.id AS inseritore_id, u.email AS inseritore_email, u.nome AS inseritore_nome
                      FROM oggetti_ritrovati o
                      LEFT JOIN utenti u ON o.id_inseritore = u.id
                      ORDER BY o.data_inserimento DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Creates a simple claim request in the richieste table
         * @param int $objectId
         * @param int $claimerId
         * @param string|null $message
         * @return bool
         */
        public function createClaimRequest(int $objectId, int $claimerId, ?string $message = null): bool {
            $query = "INSERT INTO richieste (oggetto_id, richiedente_id, messaggio) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);
            if (!$stmt) return false;
            $stmt->bind_param("iis", $objectId, $claimerId, $message);
            return $stmt->execute();
        }

        /**
         * Returns the reports made by the user
         * @param int $userId
         * @return array
         */
        public function getUserReports(int $userId): array {
            $query = "SELECT * FROM oggetti_ritrovati WHERE id_inseritore = ? ORDER BY data_inserimento DESC";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Returns pending claims for a reported object
         * @param int $objectId
         * @return array
         */
        public function getPendingClaimsForReport(int $objectId): array {
            $query = "SELECT r.*, u.email AS richiedente_email, u.nome AS richiedente_nome
                      FROM richieste r
                      LEFT JOIN utenti u ON r.richiedente_id = u.id
                      WHERE r.oggetto_id = ? AND r.stato = 'pending'
                      ORDER BY r.creato DESC";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $objectId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Updates the status of a claim
         * @param int $claimId
         * @param string $status ('accettata' or 'rifiutata')
         * @return bool
         */
        public function updateClaimStatus(int $claimId, string $status): bool {
            $query = "UPDATE richieste SET stato = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            if (!$stmt) return false;
            $stmt->bind_param("si", $status, $claimId);
            return $stmt->execute();
        }
    }
?>