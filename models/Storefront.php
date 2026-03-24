<?php
class Storefront {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getSection($section) {
        $stmt = $this->db->prepare(
            'SELECT * FROM storefront_settings WHERE section = ? LIMIT 1'
        );
        $stmt->execute([$section]);
        return $stmt->fetch();
    }

    public function getAllSections() {
        $stmt = $this->db->query('SELECT * FROM storefront_settings ORDER BY section');
        return $stmt->fetchAll();
    }

    public function updateSection($section, $productIds, $bannerText = null) {
        $stmt = $this->db->prepare(
            'INSERT INTO storefront_settings (section, product_ids, banner_text, updated_at)
             VALUES (:section, :product_ids, :banner_text, NOW())
             ON DUPLICATE KEY UPDATE product_ids = :product_ids2, banner_text = :banner_text2, updated_at = NOW()'
        );
        $json = json_encode(array_values(array_map('intval', $productIds)));
        return $stmt->execute([
            ':section'      => $section,
            ':product_ids'  => $json,
            ':product_ids2' => $json,
            ':banner_text'  => $bannerText,
            ':banner_text2' => $bannerText,
        ]);
    }

    public function getProductsForSection($section) {
        $row = $this->getSection($section);
        if (!$row || empty($row['product_ids'])) return [];
        $ids = json_decode($row['product_ids'], true);
        if (empty($ids)) return [];
        $productModel = new Product();
        return $productModel->getByIds($ids);
    }
}
