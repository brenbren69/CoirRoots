<?php
class Transaction {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getByUser($userId) {
        $stmt = $this->db->prepare(
            'SELECT t.*, o.status AS order_status
             FROM transactions t JOIN orders o ON t.order_id = o.id
             WHERE t.user_id = ? ORDER BY t.created_at DESC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getByOrder($orderId) {
        $stmt = $this->db->prepare(
            'SELECT * FROM transactions WHERE order_id = ? ORDER BY created_at DESC'
        );
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }

    public function getAll() {
        $stmt = $this->db->query(
            'SELECT t.*, u.name AS buyer_name, u.email AS buyer_email
             FROM transactions t
             JOIN users u ON t.user_id = u.id
             ORDER BY t.created_at DESC'
        );
        return $stmt->fetchAll();
    }

    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare(
            'UPDATE transactions SET status = ? WHERE id = ?'
        );
        return $stmt->execute([$status, $id]);
    }
}
