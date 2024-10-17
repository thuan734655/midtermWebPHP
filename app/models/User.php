<?php
class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function login($username, $password)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function register($username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
        return $stmt->execute([$username, $hashedPassword]);
    }
    public function isUsernameTaken($username)
    {
        // Giả sử bạn có một bảng `users` trong cơ sở dữ liệu
        $query = "SELECT COUNT(*) FROM users WHERE username = :username";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Kiểm tra xem có bất kỳ bản ghi nào không
        return $stmt->fetchColumn() > 0;
    }
    public function logout()
    {
        setcookie('user_id', '', time() - 3600);
    }
}
?>