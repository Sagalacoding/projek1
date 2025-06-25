<?php
session_start();

require_once './app/models/Kategori.php';
require_once './app/models/Produk.php';

$kategoriModel = new Kategori();
$categories = $kategoriModel->getAll();
$topCategories = array_slice($categories, 0, 3);

$produkModel = new Produk();
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($searchQuery)) {
  $products = $produkModel->search($searchQuery);
} else {
  $products = $produkModel->getAll();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quinshop</title>
    <link rel="icon" type="image/png" href="public/images/Quin.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <div class="w-full h-full">
        <div 
            class="w-full h-max flex flex-col gap-4 p-5 lg:px-24 lg:pt-6 lg:pb-4 sticky top-0 bg-white text-blue border-b border-orange-800 z-50">
            <div class="w-full flex flex-wrap items-center justify-between gap-4">
                <div class="flex-1 min-w-[250px]">
                    <img src="public/images/Quinshop.png" alt="Quinshop" class="h-15 select-none">
                     <!-- <h1>Q U I N S H O P </h1> -->
                </div>

                <div class="flex-[2] w-full sm:w-auto">
                    <form action="" method="get"
                        class="w-full flex items-center gap-1 rounded-full border border-orange-500 px-3 py-2">
                        <input type="text" name="search" id="searchInput" class="w-full ring-0 outline-none text-sm"
                            placeholder="Cari produk"
                            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
                            oninput="toggleSearchButton()">
                        <button type="button" id="clearBtn"
                            class="w-[30px] h-[30px] hidden items-center justify-center rounded-full bg-orange-800 text-white cursor-pointer shrink-0"
                            onclick="clearSearch()">
                            <i class="bi bi-x"></i>
                        </button>
                        <button type="submit" id="searchBtn"
                            class="w-[30px] h-[30px] flex items-center justify-center rounded-full bg-orange-600 text-white cursor-pointer shrink-0">
                            <i class="bi bi-search"></i>
                        </button>

                    </form>
                </div>

                <div class="flex-1 flex items-center justify-end gap-3 min-w-[150px] text-sm">
                    <div class="hidden sm:block font-semibold">
                        <a href="app/views/auth/login.php">Masuk</a> /
                        <a href="app/views/auth/register.php">Daftar</a>
                    </div>
                    <!-- <div><i class="bi bi-heart text-xl"></i></div> -->
                    <div><i class="bi bi-cart text-xl"></i></div>
                </div>
            </div>

            <!-- Top categories (hidden in small screen) -->
            <div class="w-full hidden lg:flex items-center gap-6 uppercase">
                <?php foreach ($topCategories as $category): ?>
                <div class="font-semibold text-sm"><?= htmlspecialchars($category['name']) ?></div>
                <?php endforeach; ?>
            </div>
        </div>


        <div class="w-full h-full bg-gray-100 p-5 lg:px-24 lg:pt-6 lg:pb-12 flex flex-col gap-8">
            <div class="w-full h-max flex flex-col rounded-md bg-white">
                <div class="w-full p-4">
                    <span class="uppercase">KATEGORI</span>
                </div>
                <div 
                    class="w-full grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 bg-white p-6">
                    <?php foreach ($categories as $category): ?>
                        <div class="bg-white shadow-md rounded-lg p-4 flex flex-col items-center justify-between transition-transform duration-200 hover:scale-105">
                            <?php if (isset($category['image'])) : ?>
                                <img src="<?= './' . $category['image'] ?>" class="w-24 h-24 object-cover rounded" alt="<?= $category['name'] ?>">
                            <?php else: ?>
                                <div class="w-24 h-24 bg-gray-100 flex items-center justify-center rounded">
                                    <i class="bi bi-laptop text-3xl"></i>
                                </div>
                            <?php endif; ?>
                            <h3 class="font-semibold text-lg mt-4 text-center"><?= $category['name'] ?></h3>
                            <p class="text-sm text-gray-500 mt-1">Kategori Produk</p>
                            <a href="#produk?kategori=<?= urlencode($category['name']) ?>" class="mt-4">
                            <button class="bg-orange-400 hover:bg-orange-300 text-black font-semibold py-2 px-4 rounded-full">
                                Lihat Produk
                            </button>
                            </a>

                        </div>

                    <?php endforeach; ?>
                </div>

            </div>

            <div class="w-full h-max flex flex-col gap-4">
                <div class="w-full h-max flex flex-col rounded-md bg-white p-4 border-b border-orange-600 text-center">
                    <h1  id="produk" class="uppercase text-orange-600">PRODUK</h1>
                </div>

                <div class="w-full h-max grid grid-cols-1 lg:grid-cols-6 gap-4">
    <?php foreach ($products as $product): ?>
    <div
        class="w-full h-[300px] flex flex-col gap-2 bg-white shadow transition-transform duration-200 hover:shadow-none hover:scale-105 hover:outline hover:outline-1 hover:outline-green-700 cursor-pointer">
        <div class="w-full h-[150px] bg-gray-100 shrink-0 flex items-center justify-center">
            <?php if (!empty($product['image'])): ?>
            <img src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['title']) ?>"
                class="w-full h-full object-cover" />
            <?php else: ?>
            <i class="bi bi-image text-3xl"></i>
            <?php endif; ?>
        </div>
        <div class="w-full flex flex-col gap-2 px-4 py-1">
            <span class="line-clamp-2 break-all text-black"><?= htmlspecialchars($product['title']) ?></span>
            <div class="w-full h-[100px] flex flex-col gap-2">
                <div
                    class="w-full px-2 py-0.5 border border-green-600 rounded-xs text-xs text-green-800 bg-green-50">
                    Termurah di Quinshop
                </div>
                <div class="w-full h-[20px]">
                    <div class="font-semibold text-green-700">
                        <span class="text-sm text-black">Rp</span>
                        <?= !empty($product['totalPrice']) ? number_format($product['totalPrice'], 0, ',', '.') : '0' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

                <a href="<?= !empty($_SESSION['user']['id_user']) ? '' : 'app/views/auth/login.php';  ?>"
                    class="w-max px-3 py-2 my-4 mx-auto rounded-md shadow bg-white hover:bg-gray-100 active:transition-transform active:duration-200 active:scale-95 cursor-pointer">
                    <?= !empty($_SESSION['user']['id_user']) ? 'Lihat semua produk' : 'Masuk untuk melihat semua produk';  ?>
                </a>
            </div>
        </div>

        <!-- Footer -->
<footer class="bg-white text-sm text-black px-5 lg:px-24 pt-10 pb-6">
  <div class="grid grid-cols-2 md:grid-cols-5 gap-8 mb-10">
    
    <!-- Dapatkan Dukungan -->
    <div>
      <h4 class="font-semibold mb-4">Dapatkan dukungan</h4>
      <ul class="space-y-2">
        <li>Pusat Bantuan</li>
        <li>Obrolan langsung</li>
        <li>Periksa status pesanan</li>
        <li>Pengembalian dana</li>
        <li>Laporkan penyalahgunaan</li>
      </ul>
    </div>

    <!-- Trade Assurance -->
    <div>
      <h4 class="font-semibold mb-4">Trade Assurance</h4>
      <ul class="space-y-2">
        <li>Pembayaran aman dan mudah</li>
        <li>Kebijakan uang kembali</li>
        <li>Pengiriman tepat waktu</li>
        <li>Perlindungan purnajual</li>
        <li>Layanan pemantauan produk</li>
      </ul>
    </div>

    <!-- Beli di Quinshop -->
    <div>
      <h4 class="font-semibold mb-4">Beli di Quinshop</h4>
      <ul class="space-y-2">
        <li>Permintaan Kuotasi Harga</li>
        <li>Program keanggotaan</li>
        <li>Quinshop Logistics</li>
        <li>Pajak penjualan dan PPN</li>
        <li>Quinshop Reads</li>
      </ul>
    </div>

    <!-- Jual di Quinshop -->
    <div>
      <h4 class="font-semibold mb-4">Jual di Quinshop</h4>
      <ul class="space-y-2">
        <li>Mulai menjual</li>
        <li>Pusat Penjual</li>
        <li>Menjadi Pemasok Terverifikasi</li>
        <li>Kemitraan</li>
        <li>Unduh aplikasi untuk pemasok</li>
      </ul>
    </div>

    <!-- Mengenal Kami -->
    <div>
      <h4 class="font-semibold mb-4">Mengenal kami</h4>
      <ul class="space-y-2">
        <li>Tentang Quinshop</li>
        <li>Tanggung jawab perusahaan</li>
        <li>Pusat berita</li>
        <li>Karir</li>
      </ul>
    </div>

  </div>

  <!-- Sosial Media -->
  <div class="flex items-center space-x-6 mb-6 text-xl">
    <i class="fab fa-facebook-f"></i>
    <i class="fab fa-linkedin-in"></i>
    <i class="fab fa-twitter"></i>
    <i class="fab fa-instagram"></i>
    <i class="fab fa-youtube"></i>
    <i class="fab fa-tiktok"></i>
  </div>

  <!-- Unduh Aplikasi -->
  <p class="mb-4">Jual beli di mana saja dengan <a href="#" class="text-blue-600 underline">aplikasi Quinshop</a></p>
  <div class="flex space-x-4 mb-6">
    <img src="public/images/appstore.jpeg" alt="App Store" class="h-10">
    <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" class="h-10">
  </div>

  <!-- Link Footer Bawah -->
  <div class="text-xs text-gray-600 flex flex-wrap gap-4 mb-2">
    <a href="#">AliExpress</a>
    <a href="#">1688.com</a>
    <a href="#">Tmall Taobao World</a>
    <a href="#">Alipay</a>
    <a href="#">Lazada</a>
    <a href="#">Taobao Global</a>
  </div>

  <!-- Kebijakan dan Hak Cipta -->
  <div class="text-xs text-gray-600 space-x-3 mb-2">
    <a href="#">Kebijakan dan aturan</a>
    <a href="#">Pemberitahuan Legal</a>
    <a href="#">Kebijakan Daftar Produk</a>
    <a href="#">Perlindungan Kekayaan Intelektual</a>
    <a href="#">Kebijakan Privasi</a>
    <a href="#">Ketentuan Penggunaan</a>
    <a href="#">Kepatuhan Terhadap Integritas</a>
  </div>

  <p class="text-xs text-gray-500 mt-4">
    © 1999–2025 Quinshop. 版权所有: 杭州阿里巴巴海外信息技术有限公司 | 浙公网安备 33010002000092号 | 浙ICP备2024067534号
  </p>
</footer>


  <!-- FontAwesome CDN -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</body>

</html>

<script>
function toggleSearchButton() {
    const input = document.getElementById('searchInput')
    const searchBtn = document.getElementById('searchBtn')
    const clearBtn = document.getElementById('clearBtn')

    if (input.value.trim()) {
        searchBtn.classList.add('hidden')
        clearBtn.classList.remove('hidden')
        clearBtn.classList.add('flex')
    } else {
        clearBtn.classList.add('hidden')
        clearBtn.classList.remove('flex')
        searchBtn.classList.remove('hidden')
    }
}

function clearSearch() {
    const input = document.getElementById('searchInput')
    input.value = ''
    input.focus()
    toggleSearchButton()
}

window.addEventListener('DOMContentLoaded', () => {
    toggleSearchButton()
})
</script>