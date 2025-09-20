<main class="flex-1 p-6 bg-gray-100">
    <div class="p-6 md:p-8">
        <header class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800"><?php echo trans('account_management'); ?></h1>
            <p class="text-gray-600 mt-2 text-lg"><?php echo trans('manage_team_and_subscription'); ?></p>
        </header>

        <!-- Subscription Info -->
        <div class="mb-8 bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-4"><?php echo trans('subscription_details'); ?></h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-gray-500"><?php echo trans('current_plan'); ?></p>
                    <p class="mt-1 text-xl font-semibold text-solar-blue"><?php echo htmlspecialchars(ucfirst($data['subscription']->plan_name)); ?></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-gray-500"><?php echo trans('team_members'); ?></p>
                    <p class="mt-1 text-xl font-semibold text-gray-800"><?php echo $data['user_count']; ?> / <?php echo $data['subscription']->max_users; ?> <?php echo trans('users'); ?></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-gray-500"><?php echo trans('renews_on'); ?></p>
                    <p class="mt-1 text-xl font-semibold text-gray-800"><?php echo date('M d, Y', strtotime($data['subscription']->end_date)); ?></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Add User Form -->
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4"><?php echo trans('add_new_user'); ?></h2>
                    <?php if (isset($_GET['error']) && $_GET['error'] === 'limit_reached'): ?>
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                            <p class="font-bold"><?php echo trans('user_limit_reached'); ?></p>
                            <p><?php echo trans('upgrade_to_add_users'); ?></p>
                        </div>
                    <?php elseif ($data['user_count'] >= $data['subscription']->max_users): ?>
                         <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                            <p class="font-bold"><?php echo trans('user_limit_reached'); ?></p>
                            <p><?php echo trans('cannot_add_more_users'); ?></p>
                        </div>
                    <?php else: ?>
                        <form action="<?php echo URLROOT; ?>/account/add" method="POST" class="space-y-4">
                            <?php \App\Core\CSRF::tokenField(); ?>
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700"><?php echo trans('full_name'); ?></label>
                                <input type="text" name="name" id="name" required class="mt-1 w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-solar-blue">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700"><?php echo trans('email'); ?></label>
                                <input type="email" name="email" id="email" required class="mt-1 w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-solar-blue">
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700"><?php echo trans('password'); ?></label>
                                <input type="password" name="password" id="password" required class="mt-1 w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-solar-blue">
                            </div>
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700"><?php echo trans('role'); ?></label>
                                <select name="role_id" id="role" class="mt-1 w-full p-3 border border-gray-300 bg-white rounded-lg focus:ring-2 focus:ring-solar-blue">
                                    <?php foreach ($data['roles'] as $role): ?>
                                        <?php if ($role->name !== 'Admin'): // Non-admins cannot create other admins ?>
                                            <option value="<?php echo $role->id; ?>"><?php echo htmlspecialchars($role->name); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="w-full bg-solar-blue text-white font-bold py-3 px-4 rounded-lg hover:bg-opacity-90 transition-opacity">
                                    <?php echo trans('add_user'); ?>
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Users List -->
            <div class="lg:col-span-2">
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4"><?php echo trans('current_users'); ?></h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider"><?php echo trans('name'); ?></th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider"><?php echo trans('email'); ?></th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider"><?php echo trans('role'); ?></th>
                                    <th class="relative px-6 py-3"><span class="sr-only"><?php echo trans('actions'); ?></span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($data['users'] as $user): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($user->name); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($user->email); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $user->role === 'Admin' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800'; ?>">
                                                <?php echo htmlspecialchars(ucfirst($user->role)); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <?php if ($user->id != $_SESSION['user_id']): ?>
                                                <a href="<?php echo URLROOT; ?>/account/delete/<?php echo $user->id; ?>" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
