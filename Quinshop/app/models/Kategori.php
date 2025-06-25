<?php
require_once __DIR__ . '/../../config/database.php';

class Kategori
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        return $this->db->select('category');
    }

    public function getById($id)
    {
        $where = ['id_category' => $id];
        $result = $this->db->select('category', $where);
        return !empty($result) ? $result[0] : null;
    }

    public function add($name, $image)
    {
        if (empty($name) || empty($image)) {
            throw new Exception("Nama dan gambar tidak boleh kosong.");
        }

        $data = [
            'name' => $name,
            'image' => $image
        ];
        return $this->db->insert('category', $data);
    }

    public function update($id, $name, $image = null)
    {
        if (empty($name)) {
            throw new Exception("Nama tidak boleh kosong.");
        }

        $data = ['name' => $name];

        if ($image !== null) {
            $data['image'] = $image;
        }

        $where = ['id_category' => $id];
        return $this->db->update('category', $data, $where);
    }

    public function delete($id)
    {
        $where = ['id_category' => $id];
        return $this->db->delete('category', $where);
    }
}
