<main class="flex-1 p-6 bg-gray-100">
    <h1 class="text-3xl font-bold text-gray-800 mb-6"><?php echo trans('edit_subscription'); ?> #<?php echo htmlspecialchars($data['subscription']->id); ?></h1>

    <div class="bg-white shadow-md rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800"><?php echo trans('subscription_details'); ?></h2>
        </div>
        <div class="p-6">
            <form action="<?php echo URLROOT; ?>/subscriptions/update/<?php echo $data['subscription']->id; ?>" method="post">
                <?php \App\Core\CSRF::tokenField(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="plan_name" class="block text-sm font-medium text-gray-700"><?php echo trans('plan_name'); ?></label>
                        <input type="text" name="plan_name" id="plan_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="<?php echo htmlspecialchars($data['subscription']->plan_name); ?>" required>
                    </div>
                    <div>
                        <label for="max_users" class="block text-sm font-medium text-gray-700"><?php echo trans('max_users'); ?></label>
                        <input type="number" name="max_users" id="max_users" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="<?php echo $data['subscription']->max_users; ?>" required>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700"><?php echo trans('start_date'); ?></label>
                        <input type="date" name="start_date" id="start_date" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="<?php echo $data['subscription']->start_date; ?>" required>
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700"><?php echo trans('end_date'); ?></label>
                        <input type="date" name="end_date" id="end_date" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="<?php echo $data['subscription']->end_date; ?>" required>
                    </div>
                </div>
                <div class="mt-6">
                    <label for="status" class="block text-sm font-medium text-gray-700"><?php echo trans('status'); ?></label>
                    <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="active" <?php echo $data['subscription']->status === 'active' ? 'selected' : ''; ?>><?php echo trans('active'); ?></option>
                        <option value="expired" <?php echo $data['subscription']->status === 'expired' ? 'selected' : ''; ?>><?php echo trans('expired'); ?></option>
                        <option value="cancelled" <?php echo $data['subscription']->status === 'cancelled' ? 'selected' : ''; ?>><?php echo trans('cancelled'); ?></option>
                    </select>
                </div>
                <div class="mt-8 flex justify-end">
                    <a href="<?php echo URLROOT; ?>/subscriptions" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 mr-2"><?php echo trans('cancel'); ?></a>
                    <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"><?php echo trans('update_subscription'); ?></button>
                </div>
            </form>
        </div>
    </div>
</main>
