<?php
class Contact {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($name, $email, $phone) {
        $stmt = $this->pdo->prepare('INSERT INTO contacts (name, email, phone) VALUES (?, ?, ?)');
        return $stmt->execute([$name, $email, $phone]);
    }

    public function readAll() {
        $stmt = $this->pdo->query('SELECT * FROM contacts');
        return $stmt->fetchAll();
    }

    public function read($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM contacts WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update($id, $name, $email, $phone) {
        $stmt = $this->pdo->prepare('UPDATE contacts SET name = ?, email = ?, phone = ? WHERE id = ?');
        return $stmt->execute([$name, $email, $phone, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM contacts WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function search($query) {
        $stmt = $this->pdo->prepare('SELECT * FROM contacts WHERE name LIKE ? OR email LIKE ?');
        $stmt->execute(["%$query%", "%$query%"]);
        return $stmt->fetchAll();
    }
}
?>