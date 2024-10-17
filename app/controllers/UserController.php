<?php
class UserController
{
    private $userModel;

    public function __construct($userModel)
    {
        $this->userModel = $userModel;
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            try {
                // Ràng buộc tài khoản
                if (strlen($username) < 3) {
                    throw new Exception("Tên đăng nhập phải có ít nhất 3 ký tự.");
                }

                $user = $this->userModel->login($username, $password);

                if ($user) {
                    setcookie('user_id', $user['id'], time() + 3600);
                    header('Location: ./index.php');
                    exit;
                } else {
                    throw new Exception("Đăng nhập thất bại!");
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        include '../app/views/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            try {
                // Ràng buộc tài khoản
                if (strlen($username) < 3) {
                    throw new Exception("Tên đăng nhập phải có ít nhất 3 ký tự.");
                }
                if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
                    throw new Exception("Tên đăng nhập chỉ chứa chữ cái và số.");
                }
                // Ràng buộc mật khẩu
                if (strlen($password) < 8) {
                    throw new Exception("Mật khẩu phải có ít nhất 8 ký tự.");
                }
                if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) ||
                    !preg_match('/[0-9]/', $password) || !preg_match('/[\W_]/', $password)) {
                    throw new Exception("Mật khẩu phải chứa chữ hoa, chữ thường, số và ký tự đặc biệt.");
                }

                // Kiểm tra trùng lặp
                if ($this->userModel->isUsernameTaken($username)) {
                    throw new Exception("Tên đăng nhập đã tồn tại.");
                }

                if ($this->userModel->register($username, $password)) {
                    header('Location: ./index.php');
                    exit;
                } else {
                    throw new Exception("Đăng ký thất bại!");
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        include '../app/views/register.php';
    }

    public function logout()
    {
        $this->userModel->logout();
        header('Location: ./index.php');
    }
}
?>