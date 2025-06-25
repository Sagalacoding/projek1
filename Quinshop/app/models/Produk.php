<?php
require_once __DIR__ . '/../../config/database.php';

class Produk
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        return $this->db->select('product');
    }

    public function getById($id)
    {
        $where = ['id_product' => $id];
        $result = $this->db->select('product', $where);
        return !empty($result) ? $result[0] : null;
    }

    public function search($keyword)
    {
        $where = ['title' => $keyword];
        return $this->db->select('product', $where);
    }

    public function add($id_category, $id_user, $title, $price, $totalPrice, $image, $discount = 0)
    {
        if (empty($id_category) || empty($id_user) || empty($title) || empty($price) || empty($image)) {
            throw new Exception("Semua field kecuali diskon wajib diisi.");
        }

        $data = [
            'id_category' => $id_category,
            'id_user' => $id_user,
            'title' => $title,
            'price' => $price,
            'discount' => $discount,
            'image' => $image,
            'totalPrice' => $totalPrice
        ];

        return $this->db->insert('product', $data);
    }

    public function update($id_product, $id_category, $id_user, $title, $price, $totalPrice, $image, $discount = 0)
    {
        if (empty($id_category) || empty($id_user) || empty($title) || empty($price)) {
            throw new Exception("Kategori, pengguna, judul, dan harga wajib diisi.");
        }

        $data = [
            'id_category' => $id_category,
            'id_user' => $id_user,
            'title' => $title,
            'price' => $price,
            'discount' => $discount,
            'totalPrice' => $totalPrice
        ];

        if ($image !== null) {
            $data['image'] = $image;
        }

        $where = ['id_product' => $id_product];

        return $this->db->update('product', $data, $where);
    }

    public function delete($id)
    {
        $where = ['id_product' => $id];
        return $this->db->delete('product', $where);
    }
}
