<h1 class="text-3xl font-semibold mb-6"><?= isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori' ?></h1>

<div class="overflow-y-auto bg-white rounded-lg shadow">
    <form
        action="<?= isset($kategori) ? 'index.php?module=kategori&page=update&id=' . $kategori['id_category'] : 'index.php?module=kategori&page=store'; ?>"
        method="POST" enctype="multipart/form-data"
        class="w-full h-max px-12 py-6 flex flex-col items-center gap-8 bg-white rounded-xl">
        <div class="w-full flex flex-col gap-4">
            <div class="w-full flex flex-col gap-2">
                <label for="name">Nama Kategori</label>
                <input type="text" name="name" id="name" placeholder="Kategori"
                    class="w-full p-2 border border-gray-200 rounded-md"
                    value="<?= isset($kategori) ? htmlspecialchars($kategori['name']) : '' ?>" required>
            </div>

            <div class="w-full flex flex-col gap-2">
                <label for="image">Gambar Kategori</label>
                <input type="file" name="image" id="image" placeholder="Gambar" accept="image/*" class="hidden"
                    value="<?= isset($kategori) ? htmlspecialchars($kategori['image']) : '' ?>">

                <div class="w-max flex items-center gap-2">
                    <div class="w-24 h-24 rounded-lg bg-gray-200 relative">
                        <img id="imagePreview"
                            src="<?= isset($kategori) ? '/zalopedia/' . htmlspecialchars($kategori['image']) : '' ?>"
                            class="w-24 h-24 rounded-lg absolute object-cover" loading="lazy" alt="">
                    </div>

                    <label for="image"
                        class="w-max px-3 py-2 rounded-md shadow border border-gray-200 active:transition-transform active:duration-200 active:scale-95 cursor-pointer">Pilih
                        Gambar</label>
                </div>

            </div>
        </div>

        <div class="w-full flex items-center justify-end gap-2">
            <a href="<?= 'index.php?module=kategori&page=index'; ?>" type="reset"
                class="w-max px-3 py-2 rounded-md shadow active:transition-transform active:duration-200 active:scale-95 cursor-pointer">Batal</a>
            <button type="submit"
                class="w-max px-3 py-2 rounded-md shadow bg-zinc-800 text-white active:transition-transform active:duration-200 active:scale-95 cursor-pointer">Simpan</button>
        </div>
    </form>
</div>

<script>
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');

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