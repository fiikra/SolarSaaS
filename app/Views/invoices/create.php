<main class="flex-1 p-6 bg-gray-100">
    <h1 class="text-3xl font-bold text-gray-800 mb-6"><?php echo trans('create_new_invoice'); ?></h1>

    <div class="bg-white shadow-md rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800"><?php echo trans('invoice_details'); ?></h2>
        </div>
        <div class="p-6">
            <form action="<?php echo URLROOT; ?>/invoices/store" method="post">
                <?php \App\Core\CSRF::tokenField(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="client_id" class="block text-sm font-medium text-gray-700"><?php echo trans('client'); ?></label>
                        <select name="client_id" id="client_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                            <option value=""><?php echo trans('select_a_client'); ?></option>
                            <?php foreach ($data['clients'] as $client) : ?>
                                <option value="<?php echo $client->id; ?>"><?php echo htmlspecialchars($client->company_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="subscription_id" class="block text-sm font-medium text-gray-700"><?php echo trans('subscription'); ?></label>
                        <select name="subscription_id" id="subscription_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                            <option value=""><?php echo trans('select_a_subscription'); ?></option>
                            <?php foreach ($data['subscriptions'] as $subscription) : ?>
                                <option value="<?php echo $subscription->id; ?>"><?php echo htmlspecialchars($subscription->plan_name); ?> (<?php echo htmlspecialchars($subscription->company_name); ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="issue_date" class="block text-sm font-medium text-gray-700"><?php echo trans('issue_date'); ?></label>
                        <input type="date" name="issue_date" id="issue_date" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700"><?php echo trans('due_date'); ?></label>
                        <input type="date" name="due_date" id="due_date" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>
                </div>
                <hr class="my-8">
                <h3 class="text-lg font-medium leading-6 text-gray-900"><?php echo trans('invoice_items'); ?></h3>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mt-4 items-center">
                    <div class="md:col-span-6">
                        <label for="item_description" class="block text-sm font-medium text-gray-700"><?php echo trans('description'); ?></label>
                        <input type="text" name="item_description" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="<?php echo trans('item_description_placeholder'); ?>" required>
                    </div>
                    <div class="md:col-span-2">
                        <label for="item_quantity" class="block text-sm font-medium text-gray-700"><?php echo trans('quantity'); ?></label>
                        <input type="number" name="item_quantity" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="1" required>
                    </div>
                    <div class="md:col-span-4">
                        <label for="item_unit_price" class="block text-sm font-medium text-gray-700"><?php echo trans('unit_price'); ?></label>
                        <input type="number" step="0.01" name="item_unit_price" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="<?php echo trans('item_unit_price_placeholder'); ?>" required>
                    </div>
                </div>
                 <div class="mt-6">
                    <label for="amount" class="block text-sm font-medium text-gray-700"><?php echo trans('total_amount'); ?></label>
                    <input type="number" step="0.01" name="amount" id="amount" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>
                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"><?php echo trans('create_invoice'); ?></button>
                </div>
            </form>
        </div>
    </div>
</main>
