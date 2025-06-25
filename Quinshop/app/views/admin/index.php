<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user'])) {
    header('Location: ../../../index.php');
}

$currentModule = $_GET['module'] ?? '';
$currentPage = $_GET['page'] ?? '';
$id = $_GET['id'] ?? null;

$controllerFile = __DIR__ . "/../../controllers/" . ucfirst($currentModule) . "Controller.php";


if ($currentModule && $currentPage) {
    $controllerFile = __DIR__ . "/../../controllers/" . ucfirst($currentModule) . "Controller.php";

    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $controllerName = ucfirst($currentModule) . 'Controller';
        $controller = new $controllerName();

        if (method_exists($controller, $currentPage)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $currentPage === 'store') {
                $controller->store($_POST, $_FILES);
            } else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $currentPage === 'update') {
                $controller->update($id, $_POST, $_FILES);
            } else if ($currentPage === 'destroy') {
                $data = $controller->destroy($id);
            } else if ($currentPage === 'edit') {
                $data = $controller->edit($id);
            } else {
                $data = $controller->$currentPage();
            }
        } else {
            die("Method $currentPage tidak ditemukan di controller $controllerName");
        }
    } else {
        die("Controller $controllerFile tidak ditemukan");
    }
} else {
    $data = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quinshop | Admin</title>
    <link rel="icon" type="image/png" href="public/images/Loh.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen overflow-hidden">

        <div id="backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden" onclick="toggleSidebar()">
        </div>

        <aside id="sidebar"
            class="fixed md:static inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out flex flex-col justify-between">

            <div>
                <div class="p-6 text-2xl font-bold text-gray-700 border-b border-gray-200"><a
                        href="<?= 'index.php'; ?>">Quinshop Admin</a></div>
                <nav class="mt-6">
                    <ul class="space-y-2">
                        <li>
                            <a href="<?= 'index.php'; ?>"
                                class="flex items-center px-6 py-3 <?= empty($currentModule) && empty($currentPage) ? 'bg-gray-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' ?>">
                                <i class="bi bi-speedometer2 mr-3"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="<?= 'index.php?module=produk&page=index'; ?>"
                                class="flex items-center px-6 py-3 <?= ($currentModule === 'produk') ? 'bg-gray-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' ?>">
                                <i class="bi bi-box-seam mr-3"></i>
                                Produk
                            </a>
                        </li>
                        <li>
                            <a href="<?= 'index.php?module=kategori&page=index'; ?>"
                                class="flex items-center px-6 py-3 <?= ($currentModule === 'kategori') ? 'bg-gray-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' ?>">
                                <i class="bi bi-tags mr-3"></i>
                                Kategori
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="p-6 border-t border-gray-200">
                <a href="/Quinshop/app/controllers/AuthController.php?action=logout"
                    class="w-full flex items-center px-4 py-2 text-red-600 hover:bg-red-50 hover:text-red-700 rounded-md">
                    <i class="bi bi-box-arrow-right mr-3"></i>
                    Logout
                </a>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="md:hidden flex items-center justify-between p-4 bg-white shadow-md">
                <button onclick="toggleSidebar()" class="text-2xl text-gray-700">
                    <i class="bi bi-list"></i>
                </button>
                <a href="<?= 'index.php'; ?>" class="text-lg font-semibold text-blue-600">Quinshop Admin</a>
            </header>

            <main class="flex-1 p-6">
                <?php
                if (!isset($_GET['module']) && !isset($_GET['page'])) {
                    require_once 'dashboard/index.php';
                } else {
                    if (isset($data)) {
                        echo $data;
                    } else {
                        echo '<h1 class="text-2xl font-semibold text-red-600">Halaman tidak ditemukan</h1>';
                    }
                }
                ?>
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('backdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    </script>

</body>

</html>