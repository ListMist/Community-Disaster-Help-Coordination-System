<?php

require_once '../lib/Controller.php';

require_once '../models/User.php';

require_once '../models/Request.php';

session_start();

class DashboardController extends Controller {

    private $userModel;

    private $requestModel;

    public function __construct() {

        $this->userModel = new User();

        $this->requestModel = new RequestModel();

    }

    public function index() {

        if (!isset($_SESSION['user'])) {

            header('Location: /login');

            exit;

        }

        $user = $_SESSION['user'];

        $data = ['user' => $user];

        if ($user['role'] == 'affected') {

            $requests = $this->requestModel->getRequestsByUser($user['id']);

            $data['requests'] = $requests;

        } elseif ($user['role'] == 'volunteer') {

            $activeRequests = $this->requestModel->getActiveRequests();

            $data['activeRequests'] = $activeRequests;

        } elseif ($user['role'] == 'admin') {

            $allUsers = $this->userModel->getAllUsers();

            $allRequests = $this->requestModel->getAllRequests();

            $data['allUsers'] = $allUsers;

            $data['allRequests'] = $allRequests;

        }

        $this->view('dashboard/' . $user['role'], $data);

    }

    public function submitRequest() {

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'affected') {

            header('Location: /dashboard');

            exit;

        }

        $userId = $_SESSION['user']['id'];

        $type = $_POST['type'];

        $description = trim($_POST['description']);

        $urgency = $_POST['urgency'];

        $location = trim($_POST['location']);

        if ($this->requestModel->createRequest($userId, $type, $description, $urgency, $location)) {

            header('Location: /dashboard');

            exit;

        } else {

            // error

            header('Location: /dashboard');

        }

    }

    public function acceptRequest() {

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'volunteer') {

            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

                echo json_encode(['success' => false, 'message' => 'Unauthorized']);

                exit;

            } else {

                header('Location: /login');

                exit;

            }

        }

        $requestId = $_GET['id'];

        $volunteerId = $_SESSION['user']['id'];

        if ($this->requestModel->acceptRequest($requestId, $volunteerId)) {

            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

                echo json_encode(['success' => true]);

                exit;

            } else {

                header('Location: /dashboard');

                exit;

            }

        } else {

            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

                echo json_encode(['success' => false, 'message' => 'Failed to accept request']);

                exit;

            } else {

                header('Location: /dashboard');

            }

        }

    }

    public function updateStatus() {

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'volunteer') {

            header('Location: /login');

            exit;

        }

        $requestId = $_POST['request_id'];

        $status = $_POST['status'];

        if ($this->requestModel->updateStatus($requestId, $status)) {

            header('Location: /dashboard');

            exit;

        } else {

            header('Location: /dashboard');

        }

    }

    public function deleteUser() {

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {

            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

                echo json_encode(['success' => false, 'message' => 'Unauthorized']);

                exit;

            } else {

                header('Location: /login');

                exit;

            }

        }

        $userId = $_GET['id'];

        if ($this->userModel->deleteUser($userId)) {

            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

                echo json_encode(['success' => true]);

                exit;

            } else {

                header('Location: /dashboard');

                exit;

            }

        } else {

            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

                echo json_encode(['success' => false, 'message' => 'Failed to delete user']);

                exit;

            } else {

                header('Location: /dashboard');

            }

        }

    }

    public function deleteRequest() {

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {

            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

                echo json_encode(['success' => false, 'message' => 'Unauthorized']);

                exit;

            } else {

                header('Location: /login');

                exit;

            }

        }

        $requestId = $_GET['id'];

        if ($this->requestModel->deleteRequest($requestId)) {

            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

                echo json_encode(['success' => true]);

                exit;

            } else {

                header('Location: /dashboard');

                exit;

            }

        } else {

            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

                echo json_encode(['success' => false, 'message' => 'Failed to delete request']);

                exit;

            } else {

                header('Location: /dashboard');

            }

        }

    }

    public function acceptRequestById($id) {

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'volunteer') {

            header('Location: /dashboard');

            exit;

        }

        $volunteerId = $_SESSION['user']['id'];

        $this->requestModel->acceptRequest($id, $volunteerId);

        header('Location: /dashboard');

        exit;

    }

    public function deleteRequestById($id) {

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {

            header('Location: /dashboard');

            exit;

        }

        $this->requestModel->deleteRequest($id);

        header('Location: /dashboard');

        exit;

    }

    public function deleteUserById($id) {

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {

            header('Location: /dashboard');

            exit;

        }

        $this->userModel->deleteUser($id);

        header('Location: /dashboard');

        exit;

    }

}

?>