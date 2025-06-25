<?php
require_once __DIR__ . '/../../../models/Kategori.php';

$kategoriModel = new Kategori();
$categories = $kategoriModel->getAll();
?>

<h1 class="text-3xl font-semibold mb-6"><?= isset($produk) ? 'Edit Produk' : 'Tambah Produk' ?></h1>

<div class="overflow-y-auto bg-white rounded-lg shadow">
    <form
        action="<?= isset($produk) ? 'index.php?module=produk&page=update&id=' . $produk['id_product'] : 'index.php?module=produk&page=store'; ?>"
        method="POST" enctype="multipart/form-data"
        class="w-full h-max px-12 py-6 flex flex-col items-center gap-8 bg-white rounded-xl">
        <div class="w-full flex flex-col gap-4">
            <div class="w-full flex flex-col gap-2">
                <label for="title">Nama Produk</label>
                <input type="text" name="title" id="title" placeholder="Produk"
                    class="w-full p-2 border border-gray-200 rounded-md"
                    value="<?= isset($produk) ? htmlspecialchars($produk['title']) : '' ?>" required>
            </div>

            <div class="w-full flex flex-col gap-2">
                <label for="image">Gambar produk</label>
                <input type="file" name="image" id="image" placeholder="Gambar" accept="image/*" class="hidden"
                    value="<?= isset($produk) ? htmlspecialchars($produk['image']) : '' ?>">

                <div class="w-max flex items-center gap-2">
                    <div class="w-24 h-24 rounded-lg bg-gray-200 relative">
                        <img id="productPreview"
                            src="<?= isset($produk) ? '/Quinshop/' . htmlspecialchars($produk['image']) : '' ?>"
                            class="w-24 h-24 rounded-lg absolute object-cover" loading="lazy" alt="">
                    </div>

                    <label for="image"
                        class="w-max px-3 py-2 rounded-md shadow border border-gray-200 active:transition-transform active:duration-200 active:scale-95 cursor-pointer">Pilih
                        Gambar</label>
                </div>
            </div>

            <div class="w-full flex flex-col gap-2">
                <label for="price">Harga Produk</label>
                <input type="number" name="price" id="price" placeholder="Rp. 0"
                    class="w-full p-2 border border-gray-200 rounded-md"
                    value="<?= isset($produk) ? htmlspecialchars($produk['price']) : '' ?>" required>
            </div>

            <div class="w-full flex flex-col gap-2">
                <label for="discount">Diskon Produk</label>
                <input type="number" name="discount" id="discount" placeholder="0-100"
                    class="w-full p-2 border border-gray-200 rounded-md" min="0" max="100"
                    value="<?= isset($produk) ? htmlspecialchars($produk['discount']) : '' ?>">
            </div>

            <div class="w-full flex flex-col gap-2">
                <label for="description">Pilih Kategori</label>
                <select name="id_category" id="id_category" class="w-full p-2 border border-gray-200 rounded-md">
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id_category']; ?>"
                            <?= isset($produk) && $produk['id_category'] == $category['id_category'] ? 'selected' : '' ?>>
                            <?= $category['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="w-full flex items-center justify-end gap-2">
            <a href="<?= 'index.php?module=produk&page=index'; ?>" type="reset"
                class="w-max px-3 py-2 rounded-md shadow active:transition-transform active:duration-200 active:scale-95 cursor-pointer">Batal</a>
            <button type="submit"
                class="w-max px-3 py-2 rounded-md shadow bg-zinc-800 text-white active:transition-transform active:duration-200 active:scale-95 cursor-pointer">Simpan</button>
        </div>
    </form>
</div>

<script>
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('productPreview');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function(event) {
                imagePreview.src = event.target.result;
            }

            reader.readAsDataURL(file);
        }
    });
</script>