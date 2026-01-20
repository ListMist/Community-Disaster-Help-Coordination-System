<?php

// Simple router

$request = $_SERVER['REQUEST_URI'];

$request = preg_replace('#^/CDHCS/public#', '', $request);

$parts = explode('/', trim($request, '/'));

$controller = $parts[0] ?? 'auth';

$action = $parts[1] ?? 'login';

$id = $parts[2] ?? null;

if ($controller == 'login' || $controller == '') {

    $controller = 'auth';

    $action = 'login';

} elseif ($controller == 'register') {

    $controller = 'auth';

    $action = 'register';

} elseif ($controller == 'logout') {

    $controller = 'auth';

    $action = 'logout';

} elseif ($controller == 'forget-password') {

    $controller = 'auth';

    $action = 'forgetPassword';

} elseif ($controller == 'dashboard') {

    $controller = 'dashboard';

    $action = $action ?: 'index';

} elseif ($controller == 'submit-request') {

    $controller = 'dashboard';

    $action = 'submitRequest';

} elseif ($controller == 'accept-request') {

    $controller = 'dashboard';

    $action = 'acceptRequest';

} elseif ($controller == 'delete-request') {

    $controller = 'dashboard';

    $action = 'deleteRequest';

} elseif ($controller == 'delete-user') {

    $controller = 'dashboard';

    $action = 'deleteUser';

} else {

    echo '404';

    exit;

}

$controllerFile = __DIR__ . '/../app/controllers/' . ucfirst($controller) . 'Controller.php';

if (file_exists($controllerFile)) {

    require_once $controllerFile;

    $controllerClass = ucfirst($controller) . 'Controller';

    $instance = new $controllerClass();

    if (method_exists($instance, $action)) {

        if ($id) {

            $instance->$action($id);

        } else {

            $instance->$action();

        }

    } else {

        echo '404';

    }

} else {

    echo '404';

}

?>