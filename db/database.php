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

        public function getFoundObjects(): array {
            $query = "SELECT o.*, u.id AS inseritore_id, u.email AS inseritore_email
                    FROM oggetti_ritrovati o
                    LEFT JOIN utenti u ON o.id_inseritore = u.id
                    WHERE o.stato = 'approved'
                    ORDER BY o.data_inserimento DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function createClaimRequest(int $objectId, int $claimerId, ?string $message = null): bool {
            $query = "INSERT INTO richieste (oggetto_id, richiedente_id, messaggio) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);
            if (!$stmt) return false;
            $stmt->bind_param("iis", $objectId, $claimerId, $message);
            return $stmt->execute();
        }

        public function getUserReports(int $userId): array {
            $query = "SELECT * FROM oggetti_ritrovati WHERE id_inseritore = ? ORDER BY data_inserimento DESC";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getPendingClaimsForReport(int $objectId): array {
            $query = "SELECT r.*, u.email AS richiedente_email
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

        public function updateClaimStatus(int $claimId, string $status): bool {
            $query = "UPDATE richieste SET stato = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            if (!$stmt) return false;
            $stmt->bind_param("si", $status, $claimId);
            return $stmt->execute();
        }

        public function updateObjectStatus(int $objectId, string $status): bool {
            $query = "UPDATE oggetti_ritrovati SET stato = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            if (!$stmt) return false;
            $stmt->bind_param("si", $status, $objectId);
            return $stmt->execute();
        }

        public function isUserAuthorizedForClaim(int $claimId, int $userId): array | null {
            $query = "SELECT r.id, o.id as oggetto_id 
                      FROM richieste r
                      JOIN oggetti_ritrovati o ON r.oggetto_id = o.id
                      WHERE r.id = ? AND o.id_inseritore = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ii", $claimId, $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result->fetch_assoc();
        }

        public function getOpenCases(): array {
            $query = "SELECT * FROM oggetti_ritrovati WHERE stato = 'approved'";
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

        public function getObject(int $objectId): array {
            $query = "SELECT * FROM oggetti_ritrovati WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $objectId);
            $stmt->execute();

            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

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
            $this->db->begin_transaction();

            try {
                $query1 = "UPDATE richieste SET stato = 'accettata' WHERE id = ?";
                $stmt1 = $this->db->prepare($query1);
                $stmt1->bind_param("i", $claimId);
                $stmt1->execute();

                $query2 = "UPDATE oggetti_ritrovati SET stato = 'restituito' WHERE id = ?";
                $stmt2 = $this->db->prepare($query2);
                $stmt2->bind_param("i", $objectId);
                $stmt2->execute();

                $query3 = "UPDATE richieste SET stato = 'rifiutata' WHERE oggetto_id = ? AND id != ? AND stato = 'pending'";
                $stmt3 = $this->db->prepare($query3);
                $stmt3->bind_param("ii", $objectId, $claimId);
                $stmt3->execute();

                $this->db->commit();
                return true;
            } catch (Exception $e) {
                $this->db->rollback();
                return false;
            }
        }

        public function rejectClaim(int $claimId): bool {
            $query = "UPDATE richieste SET stato = 'rifiutata' WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $claimId);
            return $stmt->execute();
        }

        public function deleteReport(int $objectId, int $userId, bool $isAdmin = false): bool {
            $queryCheck = "SELECT id, id_inseritore, foto FROM oggetti_ritrovati WHERE id = ?";
            $stmtCheck = $this->db->prepare($queryCheck);
            $stmtCheck->bind_param("i", $objectId);
            $stmtCheck->execute();
            $result = $stmtCheck->get_result();

            if ($result->num_rows === 0) {
                return false;
            }
            $objData = $result->fetch_assoc();

            if (!$isAdmin && $objData['id_inseritore'] != $userId) {
                return false;
            }

            $this->db->begin_transaction();

            try {
                $queryReq = "DELETE FROM richieste WHERE oggetto_id = ?";
                $stmtReq = $this->db->prepare($queryReq);
                $stmtReq->bind_param("i", $objectId);
                $stmtReq->execute();

                $queryObj = "DELETE FROM oggetti_ritrovati WHERE id = ?";
                $stmtObj = $this->db->prepare($queryObj);
                $stmtObj->bind_param("i", $objectId);
                $stmtObj->execute();

                $this->db->commit();

                if (!empty($objData['foto'])) {
                    $filePath = __DIR__ . "/../uploads/" . $objData['foto'];
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                return true;
            } catch (Exception $e) {
                $this->db->rollback();
                return false;
            }
        }
    }
?>