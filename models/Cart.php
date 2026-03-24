<?php
class Cart {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getByUser($userId) {
        $stmt = $this->db->prepare(
            'SELECT c.*, p.name, p.price, p.image, p.stock, p.slug
             FROM carts c
             JOIN products p ON c.product_id = p.id
             WHERE c.user_id = ?
             ORDER BY c.created_at DESC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function addItem($userId, $productId, $quantity = 1) {
        $stmt = $this->db->prepare(
            'INSERT INTO carts (user_id, product_id, quantity, created_at, updated_at)
             VALUES (:user_id, :product_id, :quantity, NOW(), NOW())
             ON DUPLICATE KEY UPDATE quantity = quantity + :quantity2, updated_at = NOW()'
        );
        return $stmt->execute([
            ':user_id'    => $userId,
            ':product_id' => $productId,
            ':quantity'   => $quantity,
            ':quantity2'  => $quantity,
        ]);
    }

    public function updateQuantity($userId, $productId, $quantity) {
        if ($quantity <= 0) {
            return $this->removeItem($userId, $productId);
        }
        $stmt = $this->db->prepare(
            'UPDATE carts SET quantity = ?, updated_at = NOW()
             WHERE user_id = ? AND product_id = ?'
        );
        return $stmt->execute([$quantity, $userId, $productId]);
    }

    public function removeItem($userId, $productId) {
        $stmt = $this->db->prepare(
            'DELETE FROM carts WHERE user_id = ? AND product_id = ?'
        );
        return $stmt->execute([$userId, $productId]);
    }

    public function clearCart($userId) {
        $stmt = $this->db->prepare('DELETE FROM carts WHERE user_id = ?');
        return $stmt->execute([$userId]);
    }

    public function getTotal($userId) {
        $stmt = $this->db->prepare(
            'SELECT SUM(c.quantity * p.price) AS total
             FROM carts c JOIN products p ON c.product_id = p.id
             WHERE c.user_id = ?'
        );
        $stmt->execute([$userId]);
        $row = $stmt->fetch();
        return $row['total'] ?? 0;
    }

    public function getCount($userId) {
        $stmt = $this->db->prepare(
            'SELECT SUM(quantity) AS cnt FROM carts WHERE user_id = ?'
        );
        $stmt->execute([$userId]);
        $row = $stmt->fetch();
        return (int)($row['cnt'] ?? 0);
    }

    public function mergeSessionCart($userId, $sessionCart) {
        if (empty($sessionCart)) return;
        foreach ($sessionCart as $productId => $qty) {
            $this->addItem($userId, $productId, $qty);
        }
    }
}
