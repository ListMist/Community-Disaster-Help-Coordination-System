<?php

require_once __DIR__ . '/../controllers/Model.php';

class User extends Model {

    public function register($username, $email, $password, $role) {

        // Check if email already exists

        $sqlCheck = "SELECT * FROM users WHERE email=?";

        $stmtCheck = mysqli_prepare($this->conn, $sqlCheck);

        mysqli_stmt_bind_param($stmtCheck, "s", $email);

        mysqli_stmt_execute($stmtCheck);

        $resultCheck = mysqli_stmt_get_result($stmtCheck);

        if (mysqli_num_rows($resultCheck) > 0) {

            return "email_exists";

        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashed, $role);

        return mysqli_stmt_execute($stmt);

    }

    public function login($email, $password) {

        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "s", $email);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {

            return $user;

        }

        return false;

    }

    public function getUserById($id) {

        $sql = "SELECT * FROM users WHERE id = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "i", $id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);

    }

    public function updateProfile($id, $data) {

        // Implement profile update logic

        $fields = [];

        $values = [];

        $types = "";

        if (isset($data['email'])) {

            $fields[] = 'email = ?';

            $values[] = $data['email'];

            $types .= "s";

        }

        if (isset($data['username'])) {

            $fields[] = 'username = ?';

            $values[] = $data['username'];

            $types .= "s";

        }

        $values[] = $id;

        $types .= "i";

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, $types, ...$values);

        return mysqli_stmt_execute($stmt);

    }

    public function changePassword($id, $newPassword) {

        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password = ? WHERE id = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "si", $hashed, $id);

        return mysqli_stmt_execute($stmt);

    }

    public function resetPassword($email) {

        $sql = "SELECT id FROM users WHERE email = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "s", $email);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_fetch_assoc($result)) {

            $newPassword = password_hash('reset123', PASSWORD_DEFAULT);

            $sql = "UPDATE users SET password = ? WHERE email = ?";

            $stmt = mysqli_prepare($this->conn, $sql);

            mysqli_stmt_bind_param($stmt, "ss", $newPassword, $email);

            return mysqli_stmt_execute($stmt);

        }

        return false;

    }

    public function getAllUsers() {

        $sql = "SELECT * FROM users ORDER BY created_at DESC";

        $result = mysqli_query($this->conn, $sql);

        $rows = [];

        while($r = mysqli_fetch_assoc($result)) $rows[] = $r;

        return $rows;

    }

    public function deleteUser($id) {

        $sql = "DELETE FROM users WHERE id = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "i", $id);

        return mysqli_stmt_execute($stmt);

    }

}

?>