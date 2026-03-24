<?php
class Category {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query('SELECT * FROM categories ORDER BY name ASC');
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getBySlug($slug) {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE slug = ? LIMIT 1');
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
}
