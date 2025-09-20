<main class="flex-1 p-6 bg-gray-100">
    <div class="p-6">
        <h1 class="text-3xl font-bold text-gray-800"><?php echo trans('create_new_project'); ?></h1>

        <div class="mt-6 bg-white p-6 rounded-lg shadow">
            <form action="<?php echo URLROOT; ?>/project/store" method="POST" class="space-y-6">
                <?php \App\Core\CSRF::tokenField(); ?>
                <div>
                    <label for="project_name" class="block text-sm font-medium text-gray-700"><?php echo trans('project_name'); ?></label>
                    <input type="text" name="project_name" id="project_name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="customer_name" class="block text-sm font-medium text-gray-700"><?php echo trans('customer'); ?></label>
                    <input type="text" name="customer_name" id="customer_name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="region_id" class="block text-sm font-medium text-gray-700"><?php echo trans('region'); ?></label>
                    <select name="region_id" id="region_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value=""><?php echo trans('select_a_region'); ?></option>
                        <?php foreach ($data['regions'] as $region): ?>
                            <option value="<?php echo $region->id; ?>"><?php echo htmlspecialchars($region->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex justify-end">
                    <a href="<?php echo URLROOT; ?>/projects" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300"><?php echo trans('cancel'); ?></a>
                    <button type="submit" class="ml-3 bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700"><?php echo trans('create_project'); ?></button>
                </div>
            </form>
        </div>
    </div>
</main>
