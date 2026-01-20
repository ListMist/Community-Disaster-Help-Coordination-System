<?php

require_once '../../lib/Model.php';

class RequestModel extends Model {

    public function createRequest($userId, $type, $description, $urgency, $location) {

        $stmt = $this->db->prepare("INSERT INTO help_requests (user_id, type, description, urgency, location) VALUES (?, ?, ?, ?, ?)");

        return $stmt->execute([$userId, $type, $description, $urgency, $location]);

    }

    public function getRequestsByUser($userId) {

        $stmt = $this->db->prepare("SELECT * FROM help_requests WHERE user_id = ?");

        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getAllRequests() {

        $stmt = $this->db->query("SELECT hr.*, u.username FROM help_requests hr JOIN users u ON hr.user_id = u.id");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getActiveRequests() {

        $stmt = $this->db->query("SELECT hr.*, u.username FROM help_requests hr JOIN users u ON hr.user_id = u.id WHERE status = 'pending'");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function acceptRequest($requestId, $volunteerId) {

        $stmt = $this->db->prepare("UPDATE help_requests SET status = 'accepted', accepted_by = ? WHERE id = ? AND status = 'pending'");

        return $stmt->execute([$volunteerId, $requestId]);

    }

    public function updateStatus($requestId, $status) {

        $stmt = $this->db->prepare("UPDATE help_requests SET status = ? WHERE id = ?");

        return $stmt->execute([$status, $requestId]);

    }

    public function deleteRequest($requestId) {

        $stmt = $this->db->prepare("DELETE FROM help_requests WHERE id = ?");

        return $stmt->execute([$requestId]);

    }

}

?>