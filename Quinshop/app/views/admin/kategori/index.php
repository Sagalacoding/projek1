<h1 class="text-3xl font-semibold mb-6">Kategori</h1>

<?php if (empty($kategori)) : ?>
<div class="overflow-x-auto bg-white rounded-lg shadow">
    <div class="w-full h-max p-4">
        <a href="<?= 'index.php?module=kategori&page=create'; ?>"
            class="w-max px-3 py-2 rounded-md shadow bg-zinc-800 text-white active:transition-transform active:duration-200 active:scale-95 cursor-pointer">Buat
            Kategori</a>
        <p class="text-gray-500 mt-4">Belum ada data kategori.</p>
    </div>
</div>
<?php else : ?>
<div class="flex flex-col gap-4">
    <a href="<?= 'index.php?module=kategori&page=create'; ?>"
        class="w-max px-3 py-2 rounded-md shadow bg-zinc-800 text-white active:transition-transform active:duration-200 active:scale-95 cursor-pointer">Buat
        Kategori</a>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Nama</th>
                    <th class="px-6 py-4">Gambar</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php $no = 1;
                    foreach ($kategori as $item) : ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium"><?= $no++ ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($item['name']) ?></td>
                    <td class="px-6 py-4">
                        <div class="w-24 h-24 bg-gray-200 rounded-lg">
                            <img src="<?= '/zalopedia/' . htmlspecialchars($item['image']) ?>"
                                alt="<?= htmlspecialchars($item['name']) ?>"
                                class="w-full h-full rounded-lg object-cover">
                        </div>
                    </td>
                    <td class="flex items-center gap-2 px-6 py-4">
                        <a href="<?= 'index.php?module=kategori&page=edit&id=' . $item['id_category']; ?>"
                            class="w-max px-3 py-2 rounded-md shadow bg-zinc-800 text-white active:transition-transform active:duration-200 active:scale-95 cursor-pointer">
                            Edit</a>
                        <a href="<?= 'index.php?module=kategori&page=destroy&id=' . $item['id_category']; ?>"
                            class="w-max px-3 py-2 rounded-md shadow bg-zinc-800 text-white active:transition-transform active:duration-200 active:scale-95 cursor-pointer"
                            onclick="return confirm('Apakah anda yakin?');">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
<?php endif; ?>