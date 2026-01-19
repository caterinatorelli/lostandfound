<?php
    class Database {
        private $db;
        
        private function getUser(string $username): array | null {
            $query = "SELECT id, email, password, ruolo FROM utenti WHERE email = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("s", $username);

            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_assoc();
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
        public function checkLogin(string $username, string $password): array | null {
            $user = $this->getUser($username);

            if (password_verify($password, password_hash($password, PASSWORD_DEFAULT))) {
                return $user;
            } else {
                return null;
            }
        }

        public function registerUser(string $username, string $password): void {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
            $query = "INSERT INTO utenti (email, password) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ss", $username, $password_hash);

            $stmt->execute();
        }

        public function insertOggetto($nome, $categoria, $luogo, $data, $foto, $userId) {
            $query = "INSERT INTO oggetti_ritrovati (nome, categoria, luogo, data_ritrovamento, foto, id_inseritore) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            if (!$stmt) return false; 
            
            $stmt->bind_param("sssssi", $nome, $categoria, $luogo, $data, $foto, $userId);
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
                    WHERE o.stato = 'approved'
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

        /**
         * Updates the status of an object
         * @param int $objectId
         * @param string $status
         * @return bool
         */
        public function updateObjectStatus(int $objectId, string $status): bool {
            $query = "UPDATE oggetti_ritrovati SET stato = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            if (!$stmt) return false;
            $stmt->bind_param("si", $status, $objectId);
            return $stmt->execute();
        }

        /**
         * Checks if the user is authorized to manage a claim (i.e., is the owner of the reported object)
         * @param int $claimId
         * @param int $userId
         * @return bool
         */
        public function isUserAuthorizedForClaim(int $claimId, int $userId): bool {
            $query = "SELECT r.id FROM richieste r
                      JOIN oggetti_ritrovati o ON r.oggetto_id = o.id
                      WHERE r.id = ? AND o.id_inseritore = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ii", $claimId, $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->num_rows > 0;
        }

        public function getOpenCases(): array {
            $query = "SELECT * FROM oggetti_ritrovati WHERE stato = 'accettata'";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getRequests(): array {
            $query = "SELECT * FROM oggetti_ritrovati WHERE stato = 'pending'";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getSubmitter(array $object): array {
            $query = "SELECT * FROM utenti WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $object["id_inseritore"]);
            $stmt->execute();
            
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }

        /**
         * Checks if a pending claim exists for the object by the user
         * @param int $objectId
         * @param int $userId
         * @return bool
         */
        public function hasPendingClaim(int $objectId, int $userId): bool {
            $query = "SELECT id FROM richieste WHERE oggetto_id = ? AND richiedente_id = ? AND stato = 'pending'";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ii", $objectId, $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->num_rows > 0;
        }

        public function approveRequest(int $oggettoId): void {
            $query = "UPDATE oggetti_ritrovati SET stato = 'approved' WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $oggettoId);
            $stmt->execute();

            $result = $stmt->get_result();
            $stmt->close();
        }

        public function denyRequest(int $oggettoId): void {
            $query = "UPDATE oggetti_ritrovati SET stato = 'refused' WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $oggettoId);
            $stmt->execute();

            $result = $stmt->get_result();
            $stmt->close();
        }
        
        public function acceptClaim(int $claimId, int $objectId): bool {
            // Iniziamo una transazione per assicurarci che tutto avvenga insieme
            $this->db->begin_transaction();

            try {
                // 1. Aggiorna la richiesta specifica a 'accettata'
                $query1 = "UPDATE richieste SET stato = 'accettata' WHERE id = ?";
                $stmt1 = $this->db->prepare($query1);
                $stmt1->bind_param("i", $claimId);
                $stmt1->execute();

                // 2. Aggiorna l'oggetto a 'restituito'
                $query2 = "UPDATE oggetti_ritrovati SET stato = 'restituito' WHERE id = ?";
                $stmt2 = $this->db->prepare($query2);
                $stmt2->bind_param("i", $objectId);
                $stmt2->execute();

                // 3. Rifiuta tutte le ALTRE richieste pendenti per questo oggetto
                $query3 = "UPDATE richieste SET stato = 'rifiutata' WHERE oggetto_id = ? AND id != ? AND stato = 'pending'";
                $stmt3 = $this->db->prepare($query3);
                $stmt3->bind_param("ii", $objectId, $claimId);
                $stmt3->execute();

                // Se siamo arrivati qui senza errori, confermiamo le modifiche
                $this->db->commit();
                return true;
            } catch (Exception $e) {
                // In caso di errore, annulliamo tutto
                $this->db->rollback();
                return false;
            }
        }

        /**
         * Rifiuta una singola richiesta
         */
        public function rejectClaim(int $claimId): bool {
            $query = "UPDATE richieste SET stato = 'rifiutata' WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $claimId);
            return $stmt->execute();
        }
    }
?>