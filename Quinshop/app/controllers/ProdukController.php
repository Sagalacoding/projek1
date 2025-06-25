<?php
require_once __DIR__ . '/../models/Produk.php';

class ProdukController
{
    private $produkModel;

    public function __construct()
    {
        $this->produkModel = new Produk();
    }

    public function index()
    {
        $produk = $this->produkModel->getAll();

        if (!$produk) {
            $produk = [];
        }

        ob_start();
        require_once __DIR__ . '/../views/admin/produk/index.php';
        return ob_get_clean();
    }

    public function create()
    {
        ob_start();
        require_once __DIR__ . '/../views/admin/produk/form.php';
        return ob_get_clean();
    }

    public function edit($id)
    {
        $produk = $this->produkModel->getById($id);

        if (!$produk) {
            echo "<script>alert('Produk tidak ditemukan.'); window.history.back();</script>";
            return;
        }

        ob_start();
        require_once __DIR__ . '/../views/admin/produk/form.php';
        return ob_get_clean();
    }

    public function store($postData, $fileData)
    {
        try {
            $title = $postData['title'];
            $price = (float) $postData['price'];
            $discount = isset($postData['discount']) ? (float) $postData['discount'] : 0.00;
            $id_category = $postData['id_category'];
            $id_user = $_SESSION['user']['id_user'];
            $file = $fileData['image'];
            $totalPrice = $price - ($price * ($discount / 100));

            if (empty($title) || empty($price) || empty($id_category) || empty($id_user)) {
                throw new Exception("Field wajib tidak boleh kosong.");
            }

            $targetDir = __DIR__ . '/../../public/images/';
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
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
            $this->produkModel->add($id_category, $id_user, $title, $price, $totalPrice, $imagePath, $discount);

            echo "<script>alert('Produk berhasil ditambahkan.'); window.location.href='index.php?module=produk&page=index';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Gagal: " . $e->getMessage() . "'); window.history.back();</script>";
        }
    }

    public function update($id, $postData, $fileData)
    {
        try {
            $title = $postData['title'];
            $price = $postData['price'];
            $discount = isset($postData['discount']) ? $postData['discount'] : 0.00;
            $id_category = $postData['id_category'];
            $id_user = $_SESSION['user']['id_user'];
            $file = $fileData['image'];
            $totalPrice = $price - ($price * ($discount / 100));

            if (empty($title) || empty($price) || empty($id_category) || empty($id_user)) {
                throw new Exception("Field wajib tidak boleh kosong.");
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

            $this->produkModel->update($id, $id_category, $id_user, $title, $price, $totalPrice, $imagePath, $discount);

            echo "<script>alert('Produk berhasil diperbarui.'); window.location.href='index.php?module=produk&page=index';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Gagal memperbarui produk: " . $e->getMessage() . "'); window.history.back();</script>";
        }
    }

    public function destroy($id)
    {
        try {
            $this->produkModel->delete($id);
            echo "<script>alert('Produk berhasil dihapus.'); window.location.href='index.php?module=produk&page=index';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Gagal menghapus produk: " . $e->getMessage() . "'); window.history.back();</script>";
        }
    }
}
