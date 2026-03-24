<?php
class Order {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data) {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare(
                'INSERT INTO orders (user_id, total_amount, subtotal, shipping_fee,
                 payment_method, fulfillment_method, delivery_address, status, notes,
                 created_at, updated_at)
                 VALUES (:user_id, :total_amount, :subtotal, :shipping_fee,
                 :payment_method, :fulfillment_method, :delivery_address, :status, :notes,
                 NOW(), NOW())'
            );
            $stmt->execute([
                ':user_id'           => $data['user_id'],
                ':total_amount'      => $data['total_amount'],
                ':subtotal'          => $data['subtotal'],
                ':shipping_fee'      => $data['shipping_fee'],
                ':payment_method'    => $data['payment_method'],
                ':fulfillment_method'=> $data['fulfillment_method'],
                ':delivery_address'  => $data['delivery_address'] ?? null,
                ':status'            => 'pending',
                ':notes'             => $data['notes'] ?? null,
            ]);
            $orderId = $this->db->lastInsertId();

            foreach ($data['items'] as $item) {
                $itemStmt = $this->db->prepare(
                    'INSERT INTO order_items (order_id, product_id, product_name, quantity, price, created_at)
                     VALUES (:order_id, :product_id, :product_name, :quantity, :price, NOW())'
                );
                $itemStmt->execute([
                    ':order_id'    => $orderId,
                    ':product_id'  => $item['product_id'],
                    ':product_name'=> $item['name'],
                    ':quantity'    => $item['quantity'],
                    ':price'       => $item['price'],
                ]);
            }

            $txStmt = $this->db->prepare(
                'INSERT INTO transactions (order_id, user_id, amount, payment_method, status, created_at)
                 VALUES (:order_id, :user_id, :amount, :payment_method, :status, NOW())'
            );
            $txStmt->execute([
                ':order_id'      => $orderId,
                ':user_id'       => $data['user_id'],
                ':amount'        => $data['total_amount'],
                ':payment_method'=> $data['payment_method'],
                ':status'        => 'pending',
            ]);

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getByUser($userId) {
        $stmt = $this->db->prepare(
            'SELECT o.*,
             (SELECT COUNT(*) FROM order_items oi WHERE oi.order_id = o.id) AS item_count
             FROM orders o
             WHERE o.user_id = ?
             ORDER BY o.created_at DESC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare(
            'SELECT o.*, u.name AS buyer_name, u.email AS buyer_email
             FROM orders o
             JOIN users u ON o.user_id = u.id
             WHERE o.id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        $order = $stmt->fetch();
        if ($order) {
            $itemStmt = $this->db->prepare(
                'SELECT oi.*, p.image FROM order_items oi
                 LEFT JOIN products p ON oi.product_id = p.id
                 WHERE oi.order_id = ?'
            );
            $itemStmt->execute([$id]);
            $order['items'] = $itemStmt->fetchAll();
        }
        return $order;
    }

    public function getAll($filters = []) {
        $sql = 'SELECT o.*, u.name AS buyer_name,
                (SELECT COUNT(*) FROM order_items oi WHERE oi.order_id = o.id) AS item_count
                FROM orders o JOIN users u ON o.user_id = u.id WHERE 1=1';
        $params = [];
        if (!empty($filters['status'])) {
            $sql .= ' AND o.status = :status';
            $params[':status'] = $filters['status'];
        }
        $sql .= ' ORDER BY o.created_at DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare(
            'UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?'
        );
        return $stmt->execute([$status, $id]);
    }

    public function getTodaySales() {
        $stmt = $this->db->query(
            "SELECT COALESCE(SUM(total_amount),0) AS total, COUNT(*) AS cnt
             FROM orders WHERE DATE(created_at) = CURDATE()
             AND status != 'cancelled'"
        );
        return $stmt->fetch();
    }

    public function getMonthSales() {
        $stmt = $this->db->query(
            "SELECT COALESCE(SUM(total_amount),0) AS total, COUNT(*) AS cnt
             FROM orders
             WHERE MONTH(created_at) = MONTH(CURDATE())
             AND YEAR(created_at) = YEAR(CURDATE())
             AND status != 'cancelled'"
        );
        return $stmt->fetch();
    }

    public function getSalesByMonth($year = null) {
        $year = $year ?? date('Y');
        $stmt = $this->db->prepare(
            "SELECT MONTH(created_at) AS month,
             MONTHNAME(created_at) AS month_name,
             COALESCE(SUM(total_amount),0) AS total,
             COUNT(*) AS cnt
             FROM orders
             WHERE YEAR(created_at) = ?
             AND status != 'cancelled'
             GROUP BY MONTH(created_at), MONTHNAME(created_at)
             ORDER BY MONTH(created_at)"
        );
        $stmt->execute([$year]);
        return $stmt->fetchAll();
    }

    public function getRecentOrders($limit = 10) {
        $stmt = $this->db->prepare(
            'SELECT o.*, u.name AS buyer_name,
             (SELECT COUNT(*) FROM order_items oi WHERE oi.order_id = o.id) AS item_count
             FROM orders o JOIN users u ON o.user_id = u.id
             ORDER BY o.created_at DESC LIMIT ?'
        );
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}
