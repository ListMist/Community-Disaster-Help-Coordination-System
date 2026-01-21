<?php

require_once __DIR__ . '/../lib/Controller.php';

require_once __DIR__ . '/../models/User.php';

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

                if ($user['role'] == 'affected') {

                    header('Location: /affected_dashboard.html');

                } elseif ($user['role'] == 'volunteer') {

                    header('Location: /volunteer_dashboard.html');

                } elseif ($user['role'] == 'admin') {

                    header('Location: /admin_dashboard.html');

                } else {

                    header('Location: /dashboard');

                }

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

                if (isset($_POST['ajax']) && $_POST['ajax'] == '1') {

                    echo json_encode(['success' => false, 'error' => $error]);

                    exit;

                } else {

                    $this->view('auth/register', ['error' => $error]);

                    return;

                }

            }

            if ($this->userModel->register($username, $email, $password, $role)) {

                if (isset($_POST['ajax']) && $_POST['ajax'] == '1') {

                    echo json_encode(['success' => true]);

                    exit;

                } else {

                    header('Location: /login');

                    exit;

                }

            } else {

                $error = 'Registration failed, username or email may already exist';

                if (isset($_POST['ajax']) && $_POST['ajax'] == '1') {

                    echo json_encode(['success' => false, 'error' => $error]);

                    exit;

                } else {

                    $this->view('auth/register', ['error' => $error]);

                }

            }

        } else {

            $this->view('auth/register');

        }

    }

    public function logout() {

        session_destroy();

        header('Location: /public/index.html');

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