<main class="flex-1 p-6 bg-gray-100">
    <div class="p-6">
        <h1 class="text-3xl font-bold text-gray-800"><?php echo trans('company_profile'); ?></h1>
        <p class="text-gray-600"><?php echo trans('manage_company_details'); ?></p>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['success']; ?></span>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
            <!-- Company Details Form -->
            <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow">
                <h2 class="text-2xl font-bold text-gray-800 mb-4"><?php echo trans('company_details'); ?></h2>
                <form action="<?php echo URLROOT; ?>/company/update" method="post">
                    <?php \App\Core\CSRF::tokenField(); ?>
                    <div class="mb-4">
                        <label for="company_name" class="block text-gray-700 text-sm font-bold mb-2"><?php echo trans('company_name'); ?></label>
                        <input type="text" id="company_name" name="company_name" value="<?php echo htmlspecialchars($data['company']->company_name); ?>"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo (!empty($data['company_name_err'])) ? 'border-red-500' : ''; ?>">
                        <?php if (!empty($data['company_name_err'])): ?>
                            <p class="text-red-500 text-xs italic"><?php echo $data['company_name_err']; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="mb-4">
                        <label for="contact_email" class="block text-gray-700 text-sm font-bold mb-2"><?php echo trans('contact_email'); ?></label>
                        <input type="email" id="contact_email" name="contact_email" value="<?php echo htmlspecialchars($data['company']->contact_email); ?>"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo (!empty($data['contact_email_err'])) ? 'border-red-500' : ''; ?>">
                        <?php if (!empty($data['contact_email_err'])): ?>
                            <p class="text-red-500 text-xs italic"><?php echo $data['contact_email_err']; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            <?php echo trans('save_changes'); ?>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Subscription Details -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-2xl font-bold text-gray-800 mb-4"><?php echo trans('subscription'); ?></h2>
                <?php if ($data['subscription']): ?>
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-semibold text-gray-600"><?php echo trans('plan'); ?></h3>
                            <p class="text-lg text-gray-800"><?php echo htmlspecialchars($data['subscription']->plan_name); ?></p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-600"><?php echo trans('max_users'); ?></h3>
                            <p class="text-lg text-gray-800"><?php echo htmlspecialchars($data['subscription']->max_users); ?></p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-600"><?php echo trans('status'); ?></h3>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo ($data['subscription']->status === 'active') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                <?php echo trans(htmlspecialchars($data['subscription']->status)); ?>
                            </span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-600"><?php echo trans('subscription_end_date'); ?></h3>
                            <p class="text-lg text-gray-800"><?php echo date('F d, Y', strtotime($data['subscription']->end_date)); ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600"><?php echo trans('no_active_subscription'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
