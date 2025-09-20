<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                <?php echo trans('create_a_new_account'); ?>
            </h2>
        </div>
        <?php if (isset($data['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo $data['error']; ?></span>
            </div>
        <?php endif; ?>
        <form class="mt-8 space-y-6" action="<?php echo URLROOT; ?>/register" method="POST">
            <?php \App\Core\CSRF::tokenField(); ?>
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="company_name" class="sr-only"><?php echo trans('company_name'); ?></label>
                    <input id="company_name" name="company_name" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="<?php echo trans('company_name'); ?>" value="<?php echo $data['data']['company_name'] ?? ''; ?>">
                    <?php if (isset($data['errors']['company_name'])): ?><p class="text-red-500 text-xs italic"><?php echo $data['errors']['company_name']; ?></p><?php endif; ?>
                </div>
                <div>
                    <label for="name" class="sr-only"><?php echo trans('your_name'); ?></label>
                    <input id="name" name="name" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="<?php echo trans('your_name'); ?>" value="<?php echo $data['data']['name'] ?? ''; ?>">
                    <?php if (isset($data['errors']['name'])): ?><p class="text-red-500 text-xs italic"><?php echo $data['errors']['name']; ?></p><?php endif; ?>
                </div>
                <div>
                    <label for="email-address" class="sr-only"><?php echo trans('email_address'); ?></label>
                    <input id="email-address" name="email" type="email" autocomplete="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="<?php echo trans('email_address'); ?>" value="<?php echo $data['data']['email'] ?? ''; ?>">
                    <?php if (isset($data['errors']['email'])): ?><p class="text-red-500 text-xs italic"><?php echo $data['errors']['email']; ?></p><?php endif; ?>
                    <?php if (isset($data['errors']['email_exists'])): ?><p class="text-red-500 text-xs italic"><?php echo $data['errors']['email_exists']; ?></p><?php endif; ?>
                </div>
                <div>
                    <label for="password" class="sr-only"><?php echo trans('password'); ?></label>
                    <input id="password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="<?php echo trans('password'); ?>">
                    <?php if (isset($data['errors']['password'])): ?><p class="text-red-500 text-xs italic"><?php echo $data['errors']['password']; ?></p><?php endif; ?>
                </div>
                <div>
                    <label for="confirm_password" class="sr-only"><?php echo trans('confirm_password'); ?></label>
                    <input id="confirm_password" name="confirm_password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="<?php echo trans('confirm_password'); ?>">
                    <?php if (isset($data['errors']['confirm_password'])): ?><p class="text-red-500 text-xs italic"><?php echo $data['errors']['confirm_password']; ?></p><?php endif; ?>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <?php echo trans('register'); ?>
                </button>
            </div>
        </form>
         <p class="text-center text-sm">
            <?php echo trans('already_have_an_account'); ?> <a href="<?php echo URLROOT; ?>/login" class="font-medium text-indigo-600 hover:text-indigo-500"><?php echo trans('login_here'); ?></a>.
        </p>
    </div>
</div>
