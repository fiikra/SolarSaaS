<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                <?php echo trans('sign_in_to_your_account'); ?>
            </h2>
        </div>
        <?php if (isset($data['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo $data['error']; ?></span>
            </div>
        <?php endif; ?>
        <form class="mt-8 space-y-6" action="<?php echo URLROOT; ?>/login" method="POST">
            <?php \App\Core\CSRF::tokenField(); ?>
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="email-address" class="sr-only"><?php echo trans('email_address'); ?></label>
                    <input id="email-address" name="email" type="email" autocomplete="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="<?php echo trans('email_address'); ?>">
                </div>
                <div>
                    <label for="password" class="sr-only"><?php echo trans('password'); ?></label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="<?php echo trans('password'); ?>">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <?php echo trans('sign_in'); ?>
                </button>
            </div>
        </form>
        <p class="text-center text-sm">
            <?php echo trans('dont_have_an_account'); ?> <a href="<?php echo URLROOT; ?>/register" class="font-medium text-indigo-600 hover:text-indigo-500"><?php echo trans('register_here'); ?></a>.
        </p>
    </div>
</div>
