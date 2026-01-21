<?php

require_once '../lib/Model.php';

class RequestModel extends Model {

    public function createRequest($userId, $type, $description, $urgency, $location) {

        $sql = "INSERT INTO help_requests (user_id, type, description, urgency, location) VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "issss", $userId, $type, $description, $urgency, $location);

        return mysqli_stmt_execute($stmt);

    }

    public function getRequestsByUser($userId) {

        $sql = "SELECT * FROM help_requests WHERE user_id = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "i", $userId);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = [];

        while($r = mysqli_fetch_assoc($result)) $rows[] = $r;

        return $rows;

    }

    public function getAllRequests() {

        $sql = "SELECT hr.*, u.username FROM help_requests hr JOIN users u ON hr.user_id = u.id";

        $result = mysqli_query($this->conn, $sql);

        $rows = [];

        while($r = mysqli_fetch_assoc($result)) $rows[] = $r;

        return $rows;

    }

    public function getActiveRequests() {

        $sql = "SELECT hr.*, u.username FROM help_requests hr JOIN users u ON hr.user_id = u.id WHERE status = 'pending'";

        $result = mysqli_query($this->conn, $sql);

        $rows = [];

        while($r = mysqli_fetch_assoc($result)) $rows[] = $r;

        return $rows;

    }

    public function acceptRequest($requestId, $volunteerId) {

        $sql = "UPDATE help_requests SET status = 'accepted', accepted_by = ? WHERE id = ? AND status = 'pending'";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "ii", $volunteerId, $requestId);

        return mysqli_stmt_execute($stmt);

    }

    public function updateStatus($requestId, $status) {

        $sql = "UPDATE help_requests SET status = ? WHERE id = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "si", $status, $requestId);

        return mysqli_stmt_execute($stmt);

    }

    public function deleteRequest($requestId) {

        $sql = "DELETE FROM help_requests WHERE id = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "i", $requestId);

        return mysqli_stmt_execute($stmt);

    }

}

?>