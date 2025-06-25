<?php
require_once __DIR__ . '/../../../models/Kategori.php';

$kategoriModel = new Kategori();

function formatRupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}
?>

<h1 class="text-3xl font-semibold mb-6">Produk</h1>

<?php if (empty($produk)) : ?>
    <div class="overflow-y-auto bg-white rounded-lg shadow">
        <div class="w-full h-max p-4 space-y-4">
            <a href="<?= 'index.php?module=produk&page=create'; ?>"
                class="w-max px-3 py-2 rounded-md shadow bg-zinc-800 text-white active:transition-transform active:duration-200 active:scale-95 cursor-pointer">Buat
                Produk</a>
            <p class="text-gray-500 mt-4">Belum ada data produk.</p>
        </div>
    </div>
<?php else : ?>
    <div class="w-full flex flex-col gap-4">
        <a href="<?= 'index.php?module=produk&page=create'; ?>"
            class="w-max px-3 py-2 rounded-md shadow bg-zinc-800 text-white active:transition-transform active:duration-200 active:scale-95 cursor-pointer">Buat
            Produk</a>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">NO</th>
                        <th class="px-6 py-4">Gambar</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Diskon</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $no = 1;
                    foreach ($produk as $item) :
                        $discount = rtrim(rtrim(number_format($item['discount'], 2, '.', ''), '0'), '.'); ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium"><?= $no++ ?></td>
                            <td class="px-6 py-4">
                                <div class="w-24 h-24 bg-gray-200 rounded-lg">
                                    <img src="<?= '/Quinshop/' . htmlspecialchars($item['image']) ?>"
                                        alt="<?= htmlspecialchars($item['title']) ?>"
                                        class="w-full h-full rounded-lg object-cover">
                                </div>
                            </td>
                            <td class="px-6 py-4"><?= htmlspecialchars($item['title']) ?></td>
                            <td class="px-6 py-4">
                                <?= isset($item['totalPrice']) ? formatRupiah($item['totalPrice']) : 'Rp 0' ?>
                                </td>
                            <td class="px-6 py-4"><?= $kategoriModel->getById($item['id_category'])['name'] ?></td>
                            <td class="px-6 py-4"><?= $discount ?>%</td>
                            <td class="flex items-center gap-2 px-6 py-4">
                                <a href="<?= 'index.php?module=produk&page=edit&id=' . $item['id_product']; ?>"
                                    class="w-max px-3 py-2 rounded-md shadow bg-zinc-800 text-white active:transition-transform active:duration-200 active:scale-95 cursor-pointer">
                                    Edit</a>
                                <a href="<?= 'index.php?module=produk&page=destroy&id=' . $item['id_product']; ?>"
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