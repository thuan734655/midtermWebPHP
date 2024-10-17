<?php
require '../config/database.php';
require '../app/models/User.php';
require '../app/models/Contact.php';
require '../app/controllers/UserController.php';
require '../app/controllers/ContactController.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$userModel = new User($pdo);
$contactModel = new Contact($pdo);
$userController = new UserController($userModel);
$contactController = new ContactController($contactModel);

session_start();

if (!isset($_COOKIE['user_id'])) {
    if (isset($_GET['action']) && $_GET['action'] === 'register') {
        $userController->register();
    } else {
        $userController->login();
    }
} else {
    if (isset($_GET['q'])) {
        switch ($_GET['q']) {
            case 'add':
                $contactController->add();
                break;
            case 'delete':
                // Logic để gọi hàm delete
                break;
            case 'search':
                $contactController->search();
                break;
            default:
                $contactController->index();
        }
    } else {
        $contactController->index();
    }
}
?>