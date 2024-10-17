<?php
class ContactController {
    private $contactModel;

    public function __construct($contactModel) {
        $this->contactModel = $contactModel;
    }

    public function index() {
        $contacts = $this->contactModel->readAll();
        include '../app/views/index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->contactModel->create($_POST['name'], $_POST['email'], $_POST['phone']);
            header('Location: ./index.php');
            exit;
        }
    }

    public function delete($id) {
        $this->contactModel->delete($id);
        header('Location: ./index.php');
        exit;
    }

    public function search() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $query = $_POST['query'];
            $contacts = $this->contactModel->search($query);
            echo json_encode(['status' => 'success', 'contacts' => $contacts]);
            exit;
        }
    }
}
?>