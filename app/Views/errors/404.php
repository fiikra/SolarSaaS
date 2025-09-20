<div class="min-h-screen flex items-center justify-center bg-gray-50 text-center px-4">
    <div class="max-w-lg w-full">
        <h1 class="text-8xl md:text-9xl font-bold text-solar-blue">404</h1>
        <h2 class="text-3xl md:text-4xl font-semibold text-gray-800 mt-4"><?php echo trans('page_not_found'); ?></h2>
        <p class="text-gray-600 mt-2 text-lg"><?php echo trans('oops_the_page_you_are_looking_for_could_not_be_found'); ?></p>
        <div class="mt-8">
            <a href="<?php echo URLROOT; ?>/dashboard" class="bg-solar-blue text-white font-bold py-3 px-6 rounded-lg hover:bg-opacity-90 transition-opacity shadow-md">
                <i class="fas fa-home mr-2"></i>
                <?php echo trans('return_to_dashboard'); ?>
            </a>
        </div>
    </div>
</div>
