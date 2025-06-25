<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: ../../../app/views/admin/index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quinshop | Register</title>
    <link rel="icon" type="image/png" href="public/images/Loh.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <div class="w-full h-screen flex items-center justify-center bg-gray-100">
        <form action="../../../app/controllers/AuthController.php?action=register" method="POST"
            class="w-[500px] h-max px-12 py-6 flex flex-col items-center gap-8 bg-white rounded-xl">
            <h1 class="text-2xl font-semibold">Register</h1>

            <div class="w-full flex flex-col gap-4">
                <div class="w-full flex flex-col gap-2">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="doe@example.com"
                        class="w-full p-2 border border-gray-200 rounded-md" required>
                </div>
                <div class="w-full flex flex-col gap-2">
                    <label for="fullname">Fullname</label>
                    <input type="text" name="fullname" id="fullname" placeholder="John Doe"
                        class="w-full p-2 border border-gray-200 rounded-md" required>
                </div>
                <div class="w-full flex flex-col gap-2">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="password"
                        class="w-full p-2 border border-gray-200 rounded-md" required>
                </div>
                <div class="w-full flex flex-col gap-2">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" name="confirm-password" id="confirm-password" placeholder="confirm password"
                        class="w-full p-2 border border-gray-200 rounded-md" required>
                </div>
            </div>

            <div class="w-full flex flex-col gap-4">
                <button type="submit"
                    class="w-full p-2 bg-gray-800 rounded-md text-white active:transition-transform active:duration-200 active:scale-95 cursor-pointer">Register</button>

                <a href="login.php" class="text-center">I have an account</a>
            </div>
        </form>
    </div>
</body>

</html>