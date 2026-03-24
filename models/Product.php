<?php
class Product {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll($filters = []) {
        $sql = 'SELECT p.*, c.name AS category_name FROM products p
                LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1';
        $params = [];

        if (!empty($filters['search'])) {
            $kw = '%' . $filters['search'] . '%';
            $sql .= ' AND (p.name LIKE ? OR p.short_description LIKE ? OR p.description LIKE ?)';
            $params[] = $kw;
            $params[] = $kw;
            $params[] = $kw;
        }
        if (!empty($filters['category_id'])) {
            $sql .= ' AND p.category_id = ?';
            $params[] = $filters['category_id'];
        }

        switch ($filters['sort'] ?? 'newest') {
            case 'price_asc':  $sql .= ' ORDER BY p.price ASC'; break;
            case 'price_desc': $sql .= ' ORDER BY p.price DESC'; break;
            case 'name':       $sql .= ' ORDER BY p.name ASC'; break;
            default:           $sql .= ' ORDER BY p.created_at DESC'; break;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare(
            'SELECT p.*, c.name AS category_name FROM products p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getBySlug($slug) {
        $stmt = $this->db->prepare(
            'SELECT p.*, c.name AS category_name FROM products p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.slug = ? LIMIT 1'
        );
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public function getNewArrivals($limit = 4) {
        $stmt = $this->db->prepare(
            'SELECT p.*, c.name AS category_name FROM products p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.is_new_arrival = 1 ORDER BY p.created_at DESC LIMIT ?'
        );
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function getTrending($limit = 4) {
        $stmt = $this->db->prepare(
            'SELECT p.*, c.name AS category_name FROM products p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.is_trending = 1 ORDER BY p.created_at DESC LIMIT ?'
        );
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function getBestSellers($limit = 4) {
        $stmt = $this->db->prepare(
            'SELECT p.*, c.name AS category_name FROM products p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.is_best_seller = 1 ORDER BY p.created_at DESC LIMIT ?'
        );
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function getFeatured($limit = 6) {
        $stmt = $this->db->prepare(
            'SELECT p.*, c.name AS category_name FROM products p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.is_featured = 1 ORDER BY p.created_at DESC LIMIT ?'
        );
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare(
            'INSERT INTO products (name, slug, description, short_description, price, stock,
             category_id, image, is_featured, is_new_arrival, is_trending, is_best_seller,
             created_at, updated_at)
             VALUES (:name, :slug, :description, :short_description, :price, :stock,
             :category_id, :image, :is_featured, :is_new_arrival, :is_trending, :is_best_seller,
             NOW(), NOW())'
        );
        $stmt->execute([
            ':name'              => $data['name'],
            ':slug'              => $data['slug'],
            ':description'       => $data['description'] ?? '',
            ':short_description' => $data['short_description'] ?? '',
            ':price'             => $data['price'],
            ':stock'             => $data['stock'],
            ':category_id'       => $data['category_id'] ?? null,
            ':image'             => $data['image'] ?? null,
            ':is_featured'       => $data['is_featured'] ?? 0,
            ':is_new_arrival'    => $data['is_new_arrival'] ?? 0,
            ':is_trending'       => $data['is_trending'] ?? 0,
            ':is_best_seller'    => $data['is_best_seller'] ?? 0,
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $allowed = ['name','slug','description','short_description','price','stock',
                    'category_id','image','is_featured','is_new_arrival','is_trending','is_best_seller'];
        $fields = [];
        $params = [':id' => $id];
        foreach ($allowed as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "$field = :$field";
                $params[":$field"] = $data[$field];
            }
        }
        if (empty($fields)) return false;
        $fields[] = 'updated_at = NOW()';
        $sql = 'UPDATE products SET ' . implode(', ', $fields) . ' WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM products WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function updateStock($id, $quantity) {
        $stmt = $this->db->prepare(
            'UPDATE products SET stock = stock - ?, updated_at = NOW() WHERE id = ?'
        );
        return $stmt->execute([$quantity, $id]);
    }

    public function getByIds($ids) {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare(
            "SELECT p.*, c.name AS category_name FROM products p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.id IN ($placeholders)"
        );
        $stmt->execute($ids);
        return $stmt->fetchAll();
    }

    public function getInventorySummary() {
        $stmt = $this->db->query(
            'SELECT p.*, c.name AS category_name,
             (p.price * p.stock) AS stock_value
             FROM products p
             LEFT JOIN categories c ON p.category_id = c.id
             ORDER BY p.stock ASC'
        );
        return $stmt->fetchAll();
    }
}
