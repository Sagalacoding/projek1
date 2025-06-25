<?php
require_once __DIR__ . '/../models/Kategori.php';

class KategoriController
{
    private $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new Kategori();
    }

    public function index()
    {
        $kategori = $this->kategoriModel->getAll();

        if (!$kategori) {
            $kategori = [];
        }

        ob_start();
        require_once __DIR__ . '/../views/admin/kategori/index.php';
        return ob_get_clean();
    }

    public function create()
    {
        ob_start();
        require_once __DIR__ . '/../views/admin/kategori/form.php';
        return ob_get_clean();
    }

    public function edit($id)
    {
        $kategori = $this->kategoriModel->getById($id);

        if (!$kategori) {
            echo "<script>alert('Kategori tidak ditemukan.'); window.history.back();</script>";
            return;
        }

        ob_start();
        require_once __DIR__ . '/../views/admin/kategori/form.php';
        return ob_get_clean();
    }



    public function store($postData, $fileData)
    {
        try {
            $name = $postData['name'];
            $file = $fileData['image'];

            if (empty($name)) {
                throw new Exception("Nama wajib diisi.");
            }

            $targetDir = __DIR__ . '/../../public/images/';
            if (!file_exists($targetDir)) {
                if (!mkdir($targetDir, 0755, true)) {
                    throw new Exception("Gagal membuat folder: $targetDir");
                }
            }


            $fileName = time() . '-' . basename($file['name']);
            $targetFile = $targetDir . $fileName;

            if (!is_writable($targetDir)) {
                throw new Exception("Folder tidak bisa ditulisi: $targetDir");
            }


            if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
                throw new Exception("Gagal mengupload gambar.");
            }

            $imagePath = 'public/images/' . $fileName;
            $this->kategoriModel->add($name, $imagePath);

            echo "<script>alert('Kategori berhasil ditambahkan.'); window.location.href='index.php?module=kategori&page=index';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Gagal: " . $e->getMessage() . "'); window.history.back();</script>";
        }
    }


    public function update($id, $postData, $fileData)
    {
        try {
            $name = $postData['name'];
            $file = $fileData['image'];

            if (empty($name)) {
                throw new Exception("Nama tidak boleh kosong.");
            }

            $imagePath = null;

            if (!empty($file['name'])) {
                $targetDir = __DIR__ . '/../../public/images/';
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }

                $fileName = time() . '-' . basename($file['name']);
                $targetFile = $targetDir . $fileName;

                if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
                    throw new Exception("Gagal mengupload gambar.");
                }

                $imagePath = 'public/images/' . $fileName;
            }

            $this->kategoriModel->update($id, $name, $imagePath);

            echo "<script>alert('Kategori berhasil diperbarui.'); window.location.href='index.php?module=kategori&page=index';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Gagal memperbarui kategori: " . $e->getMessage() . "'); window.history.back();</script>";
        }
    }

    public function destroy($id)
    {
        try {
            $this->kategoriModel->delete($id);
            echo "<script>alert('Kategori berhasil dihapus.'); window.location.href='index.php?module=kategori&page=index';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Gagal menghapus kategori: " . $e->getMessage() . "'); window.history.back();</script>";
        }
    }
}
