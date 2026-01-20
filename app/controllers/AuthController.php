<?php

require_once '../../lib/Controller.php';

require_once '../models/User.php';

session_start();

class AuthController extends Controller {

    private $userModel;

    public function __construct() {

        $this->userModel = new User();

    }

    public function login() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = trim($_POST['email']);

            $password = $_POST['password'];

            $user = $this->userModel->login($email, $password);

            if ($user) {

                $_SESSION['user_id'] = $user['id'];

                $_SESSION['user_role'] = $user['role'];

                $_SESSION['user'] = $user;

                header('Location: /dashboard');

                exit;

            } else {

                $error = 'Invalid email or password';

                $this->view('auth/login', ['error' => $error]);

            }

        } else {

            $this->view('auth/login');

        }

    }

    public function register() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $username = trim($_POST['username']);

            $email = trim($_POST['email']);

            $password = $_POST['password'];

            $role = $_POST['role'];

            if (empty($username) || empty($email) || empty($password) || empty($role)) {

                $error = 'All fields are required';

                $this->view('auth/register', ['error' => $error]);

                return;

            }

            if ($this->userModel->register($username, $email, $password, $role)) {

                header('Location: /login');

                exit;

            } else {

                $error = 'Registration failed, username or email may already exist';

                $this->view('auth/register', ['error' => $error]);

            }

        } else {

            $this->view('auth/register');

        }

    }

    public function logout() {

        session_destroy();

        header('Location: /login');

        exit;

    }

    public function forgetPassword() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = trim($_POST['email']);

            if ($this->userModel->resetPassword($email)) {

                $message = 'Password has been reset to reset123. Please login and change it.';

            } else {

                $message = 'Email not found.';

            }

            $this->view('auth/forget_password', ['message' => $message]);

        } else {

            $this->view('auth/forget_password');

        }

    }

}

?>