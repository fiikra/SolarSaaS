<div class="min-h-screen flex items-center justify-center bg-gray-50 text-center px-4">
    <div class="max-w-lg w-full">
        <h1 class="text-8xl md:text-9xl font-bold text-red-600">403</h1>
        <h2 class="text-3xl md:text-4xl font-semibold text-gray-800 mt-4"><?php echo trans('access_denied'); ?></h2>
        <p class="text-gray-600 mt-2 text-lg"><?php echo trans('sorry_you_do_not_have_permission_to_access_this_page'); ?></p>
        <div class="mt-8">
            <a href="<?php echo URLROOT; ?>/dashboard" class="bg-solar-blue text-white font-bold py-3 px-6 rounded-lg hover:bg-opacity-90 transition-opacity shadow-md">
                <i class="fas fa-home mr-2"></i>
                <?php echo trans('return_to_dashboard'); ?>
            </a>
        </div>
    </div>
</div>
