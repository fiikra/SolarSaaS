<div class="bg-gray-50 text-gray-800">
    <!-- Header -->
    <header class="shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <span class="material-icons text-blue-600 text-3xl mr-2">solar_power</span>
                <h1 class="text-2xl font-bold"><?php echo SITENAME; ?></h1>
            </div>
            <div class="flex items-center space-x-4">
                <nav class="space-x-4 hidden md:flex">
                    <a href="<?php echo URLROOT; ?>/login" class="text-gray-600 hover:text-blue-600 transition"><?php echo trans('login'); ?></a>
                    <a href="<?php echo URLROOT; ?>/register" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition"><?php echo trans('register'); ?></a>
                </nav>
                <div x-data="{ isOpen: false }" class="relative">
                    <button @click="isOpen = !isOpen" class="flex items-center text-gray-600 hover:text-blue-600">
                        <span class="material-icons">language</span>
                        <span class="ml-1"><?php echo strtoupper($_SESSION['lang'] ?? 'EN'); ?></span>
                    </button>
                    <div x-show="isOpen" @click.away="isOpen = false" class="absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-lg py-2 z-10">
                        <a href="<?php echo URLROOT; ?>/lang/en" class="block px-4 py-2 text-gray-800 hover:bg-blue-500 hover:text-white">English</a>
                        <a href="<?php echo URLROOT; ?>/lang/fr" class="block px-4 py-2 text-gray-800 hover:bg-blue-500 hover:text-white">Français</a>
                        <a href="<?php echo URLROOT; ?>/lang/ar" class="block px-4 py-2 text-gray-800 hover:bg-blue-500 hover:text-white">العربية</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="container mx-auto px-6 py-16 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="md:flex md:items-center md:justify-between">
                <div class="md:w-1/2 text-left">
                    <h2 class="text-4xl font-bold mb-4"><?php echo trans('welcome_to_solarsaas'); ?></h2>
                    <p class="text-lg text-gray-600 mb-8"><?php echo trans('app_description'); ?></p>
                    <a href="<?php echo URLROOT; ?>/register" class="bg-blue-600 text-white px-8 py-3 rounded-full font-bold text-lg hover:bg-blue-700 transition"><?php echo trans('get_started_free'); ?></a>
                </div>
                <div class="md:w-1/2 mt-8 md:mt-0">
                    <!-- Placeholder for image -->
                    <div class="bg-gray-200 h-80 rounded-lg flex items-center justify-center">
                        <span class="text-gray-500"><?php echo trans('image_placeholder'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Features Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold text-center mb-12"><?php echo trans('our_features'); ?></h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                <div class="p-6 border rounded-lg shadow-lg hover:shadow-xl transition">
                    <span class="material-icons text-blue-600 text-5xl mb-4">solar_power</span>
                    <h4 class="text-xl font-bold mb-2"><?php echo trans('feature_system_design'); ?></h4>
                    <p class="text-gray-600"><?php echo trans('feature_system_design_desc'); ?></p>
                </div>
                <div class="p-6 border rounded-lg shadow-lg hover:shadow-xl transition">
                    <span class="material-icons text-blue-600 text-5xl mb-4">request_quote</span>
                    <h4 class="text-xl font-bold mb-2"><?php echo trans('feature_proposal_generation'); ?></h4>
                    <p class="text-gray-600"><?php echo trans('feature_proposal_generation_desc'); ?></p>
                </div>
                <div class="p-6 border rounded-lg shadow-lg hover:shadow-xl transition">
                    <span class="material-icons text-blue-600 text-5xl mb-4">inventory</span>
                    <h4 class="text-xl font-bold mb-2"><?php echo trans('feature_component_management'); ?></h4>
                    <p class="text-gray-600"><?php echo trans('feature_component_management_desc'); ?></p>
                </div>
                <div class="p-6 border rounded-lg shadow-lg hover:shadow-xl transition">
                    <span class="material-icons text-blue-600 text-5xl mb-4">insights</span>
                    <h4 class="text-xl font-bold mb-2"><?php echo trans('feature_project_tracking'); ?></h4>
                    <p class="text-gray-600"><?php echo trans('feature_project_tracking_desc'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; <?php echo date('Y'); ?> <?php echo SITENAME; ?>. <?php echo trans('all_rights_reserved'); ?></p>
        </div>
    </footer>
</div>


