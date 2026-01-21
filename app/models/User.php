<?php

require_once '../lib/Model.php';

class User extends Model {

    public function register($username, $email, $password, $role) {

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");

        return $stmt->execute([$username, $email, $hashed, $role]);

    }

    public function login($email, $password) {

        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");

        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {

            return $user;

        }

        return false;

    }

    public function getUserById($id) {

        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function updateProfile($id, $data) {

        // Implement profile update logic

        $fields = [];

        $values = [];

        if (isset($data['email'])) {

            $fields[] = 'email = ?';

            $values[] = $data['email'];

        }

        if (isset($data['username'])) {

            $fields[] = 'username = ?';

            $values[] = $data['username'];

        }

        $values[] = $id;

        $stmt = $this->db->prepare("UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?");

        return $stmt->execute($values);

    }

    public function changePassword($id, $newPassword) {

        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");

        return $stmt->execute([$hashed, $id]);

    }

    public function resetPassword($email) {

        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");

        $stmt->execute([$email]);

        if ($stmt->fetch()) {

            $newPassword = password_hash('reset123', PASSWORD_DEFAULT);

            $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE email = ?");

            $stmt->execute([$newPassword, $email]);

            return true;

        }

        return false;

    }

    public function getAllUsers() {

        $stmt = $this->db->query("SELECT * FROM users");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function deleteUser($id) {

        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");

        return $stmt->execute([$id]);

    }

}

?>