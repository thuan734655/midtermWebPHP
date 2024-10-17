<?php
class ContactController
{
    private $contactModel;

    public function __construct($contactModel)
    {
        $this->contactModel = $contactModel;
    }

    public function index()
    {
        $contacts = $this->contactModel->readAll();
        include '../app/views/index.php';
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->contactModel->create($_POST['name'], $_POST['email'], $_POST['phone'],$_POST['img']);
            header('Location: ./index.php');
            exit;
        }
    }

    public function view($id)
    {
        $contact = $this->contactModel->getContactById($id);

        if ($contact) {
            echo json_encode(['status' => 'success', 'contact' => $contact]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Liên hệ không tồn tại.']);
        }
    }

    public function delete($id)
    {
        $this->contactModel->delete($id);
        header('Location: ./index.php');
        exit;
    }

    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $query = $_POST['query'];
            $contacts = $this->contactModel->search($query);
            echo json_encode(['status' => 'success', 'contacts' => $contacts]);
            exit;
        }
    }
}
?>