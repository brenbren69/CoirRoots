<?php
class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findById($id) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare(
            'INSERT INTO users (name, email, password, mobile, address, role, created_at, updated_at)
             VALUES (:name, :email, :password, :mobile, :address, :role, NOW(), NOW())'
        );
        $stmt->execute([
            ':name'     => $data['name'],
            ':email'    => $data['email'],
            ':password' => $data['password'],
            ':mobile'   => $data['mobile'] ?? null,
            ':address'  => $data['address'] ?? null,
            ':role'     => $data['role'] ?? 'buyer',
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $fields = [];
        $params = [':id' => $id];
        $allowed = ['name', 'email', 'mobile', 'address', 'password'];
        foreach ($allowed as $field) {
            if (isset($data[$field])) {
                $fields[] = "$field = :$field";
                $params[":$field"] = $data[$field];
            }
        }
        if (empty($fields)) return false;
        $fields[] = 'updated_at = NOW()';
        $sql = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
}
