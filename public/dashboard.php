<?php
require_once '../app/controllers/DashboardController.php';

$controller = new DashboardController();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'accept-request':
        $controller->acceptRequest();
        break;
    case 'delete-user':
        $controller->deleteUser();
        break;
    case 'delete-request':
        $controller->deleteRequest();
        break;
    case 'submit-request':
        $controller->submitRequest();
        break;
    default:
        $controller->index();
        break;
}

?>