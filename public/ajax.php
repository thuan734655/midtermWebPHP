<?php
require '../config/database.php';
require '../app/models/Contact.php';

$contactModel = new Contact($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'add':
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $img = $_POST['img'];
            $contactModel->create($name, $email, $phone,$img);
            echo json_encode(['status' => 'success']);
            break;

        case 'delete':
            $id = $_POST['id'];
            $contactModel->delete($id);
            echo json_encode(['status' => 'success']);
            break;

        case 'search':
            $query = $_POST['query'];
            $contacts = $contactModel->search($query);
            echo json_encode(['status' => 'success', 'contacts' => $contacts]);
            break;

        case 'view':
            $id = $_POST['id'];
            $contact = $contactModel->read($id);
            if ($contact) {
                echo json_encode(['status' => 'success', 'contact' => $contact]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Contact not found']);
            }
            break;
        case 'edit':
            $id = $_POST['id'];
            $contact = $contactModel->read($id);
            if ($contact) {
                echo json_encode(['status' => 'success', 'contact' => $contact]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Contact not found']);
            }
            break;

        case 'update':
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $img = $_POST['img'];
            $contactModel->update($id, $name, $email, $phone,$img);
            echo json_encode(['status' => 'success']);
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            break;
    }
}