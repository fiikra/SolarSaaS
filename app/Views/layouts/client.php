<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang'] ?? 'en'; ?>" dir="<?php echo ($_SESSION['lang'] ?? 'en') === 'ar' ? 'rtl' : 'ltr'; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?> - <?php echo trans('client_portal'); ?></title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <!-- Tailwind -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
        .bg-sidebar { background: #3d68ff; }
        .cta-btn { color: #3d68ff; }
        .upgrade-btn { background: #1947ee; }
        .upgrade-btn:hover { background: #0038fd; }
        .active-nav-link { background: #1947ee; }
        .nav-item:hover { background: #1947ee; }
        .account-link:hover { background: #3d68ff; }
    </style>
</head>

<body class="bg-gray-100 font-family-karla flex">

    <aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
        <div class="p-6">
            <a href="<?php echo URLROOT; ?>/portal/dashboard" class="text-white text-3xl font-semibold uppercase hover:text-gray-300"><?php echo trans('client_portal'); ?></a>
        </div>
        <nav class="text-white text-base font-semibold pt-3">
            <a href="<?php echo URLROOT; ?>/portal/dashboard" class="flex items-center active-nav-link text-white py-4 pl-6 nav-item">
                <i class="fas fa-tachometer-alt mr-3"></i>
                <?php echo trans('dashboard'); ?>
            </a>
            <a href="<?php echo URLROOT; ?>/portal/projects" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-sticky-note mr-3"></i>
                <?php echo trans('my_projects'); ?>
            </a>
            <a href="<?php echo URLROOT; ?>/portal/invoices" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-file-invoice-dollar mr-3"></i>
                <?php echo trans('my_invoices'); ?>
            </a>
        </nav>
    </aside>

    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Desktop Header -->
        <header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
            <div class="w-1/2"></div>
            <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
                <button @click="isOpen = !isOpen" class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
                    <img src="https://source.unsplash.com/uJ8AL_MCdX8/100x100">
                </button>
                <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
                <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">
                    <a href="<?php echo URLROOT; ?>/logout" class="block px-4 py-2 account-link hover:text-white"><?php echo trans('sign_out'); ?></a>
                </div>
            </div>
            <div class="relative">
                <button id="lang-btn-client" class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
                    <img src="https://cdn.pixabay.com/photo/2017/02/05/14/17/globe-2040439_960_720.png">
                </button>
                <div id="lang-menu-client" class="hidden absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">
                    <a href="<?php echo URLROOT; ?>/lang/en" class="block px-4 py-2 account-link hover:text-white"><?php echo trans('english'); ?></a>
                    <a href="<?php echo URLROOT; ?>/lang/fr" class="block px-4 py-2 account-link hover:text-white"><?php echo trans('french'); ?></a>
                    <a href="<?php echo URLROOT; ?>/lang/ar" class="block px-4 py-2 account-link hover:text-white"><?php echo trans('arabic'); ?></a>
                </div>
            </div>
        </header>

        <!-- Mobile Header & Nav -->
        <header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
            <div class="flex items-center justify-between">
                <a href="<?php echo URLROOT; ?>/portal/dashboard" class="text-white text-3xl font-semibold uppercase hover:text-gray-300"><?php echo trans('client_portal'); ?></a>
                <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
                    <i x-show="!isOpen" class="fas fa-bars"></i>
                    <i x-show="isOpen" class="fas fa-times"></i>
                </button>
            </div>

            <!-- Dropdown Nav -->
            <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
                <a href="<?php echo URLROOT; ?>/portal/dashboard" class="flex items-center active-nav-link text-white py-2 pl-4 nav-item">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    <?php echo trans('dashboard'); ?>
                </a>
                <a href="<?php echo URLROOT; ?>/portal/projects" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-sticky-note mr-3"></i>
                    <?php echo trans('my_projects'); ?>
                </a>
                <a href="<?php echo URLROOT; ?>/portal/invoices" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-file-invoice-dollar mr-3"></i>
                    <?php echo trans('my_invoices'); ?>
                </a>
                <a href="<?php echo URLROOT; ?>/logout" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    <?php echo trans('sign_out'); ?>
                </a>
            </nav>
        </header>

        <div class="w-full overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <?php require_once APPROOT . '/Views/' . $view . '.php'; ?>
            </main>
    
            <footer class="w-full bg-white text-right p-4">
                <?php echo trans('built_by'); ?> <a target="_blank" href="https://davidgrzyb.com" class="underline">David Grzyb</a>.
            </footer>
        </div>

    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <script>
        document.getElementById('lang-btn-client').addEventListener('click', function() {
            document.getElementById('lang-menu-client').classList.toggle('hidden');
        });
    </script>
</body>

</html>
