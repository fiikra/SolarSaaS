<main class="flex-1 p-6 bg-gray-100">
    <div class="p-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800"><?php echo trans('project'); ?>: <?php echo htmlspecialchars($data['project']->project_name); ?></h1>
                <p class="text-gray-600"><?php echo trans('customer'); ?>: <?php echo htmlspecialchars($data['project']->customer_name); ?> | <?php echo trans('region'); ?>: <?php echo htmlspecialchars($data['project']->region_name); ?></p>
            </div>
            <form action="<?php echo URLROOT; ?>/project/updateStatus/<?php echo $data['project']->id; ?>" method="post" class="flex items-center">
                <?php \App\Core\CSRF::tokenField(); ?>
                <label for="status" class="mr-2 text-sm font-medium text-gray-700"><?php echo trans('project_status'); ?>:</label>
                <select name="status" id="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="Planning" <?php echo ($data['project']->status == 'Planning') ? 'selected' : ''; ?>><?php echo trans('planning'); ?></option>
                    <option value="In Progress" <?php echo ($data['project']->status == 'In Progress') ? 'selected' : ''; ?>><?php echo trans('in_progress'); ?></option>
                    <option value="Completed" <?php echo ($data['project']->status == 'Completed') ? 'selected' : ''; ?>><?php echo trans('completed'); ?></option>
                    <option value="Cancelled" <?php echo ($data['project']->status == 'Cancelled') ? 'selected' : ''; ?>><?php echo trans('cancelled'); ?></option>
                </select>
                <button type="submit" class="ml-3 bg-indigo-600 text-white py-1 px-3 rounded-md hover:bg-indigo-700 text-sm"><?php echo trans('update'); ?></button>
            </form>
        </div>

        <!-- Add Appliance Form -->
        <div class="mt-8 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold text-gray-800"><?php echo trans('add_appliance'); ?></h2>
            <form action="<?php echo URLROOT; ?>/project/<?php echo $data['project']->id; ?>/add_appliance" method="POST" class="mt-4 grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <?php \App\Core\CSRF::tokenField(); ?>
                <div class="md:col-span-2">
                    <label for="appliance_name" class="block text-sm font-medium text-gray-700"><?php echo trans('appliance_name'); ?></label>
                    <input type="text" name="name" id="appliance_name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="power" class="block text-sm font-medium text-gray-700"><?php echo trans('power_watts'); ?></label>
                    <input type="number" name="power" id="power" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700"><?php echo trans('quantity'); ?></label>
                    <input type="number" name="quantity" id="quantity" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="daily_usage" class="block text-sm font-medium text-gray-700"><?php echo trans('usage_h_day'); ?></label>
                    <input type="number" step="0.1" name="daily_usage_hours" id="daily_usage" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 h-fit"><?php echo trans('add'); ?></button>
            </form>
        </div>

        <!-- Appliances List -->
        <div class="mt-8 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold text-gray-800"><?php echo trans('appliances_consumption'); ?></h2>
            <table class="min-w-full divide-y divide-gray-200 mt-4">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('appliance'); ?></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('power_w'); ?></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('qty'); ?></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('usage_h_day'); ?></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('consumption_wh_day'); ?></th>
                        <th class="relative px-6 py-3"><span class="sr-only"><?php echo trans('actions'); ?></span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($data['appliances'])): ?>
                        <?php foreach ($data['appliances'] as $appliance): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($appliance->name); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo number_format($appliance->power, 2); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $appliance->quantity; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $appliance->daily_usage_hours; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo number_format($appliance->daily_consumption, 2); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="<?php echo URLROOT; ?>/project/appliance/delete/<?php echo $appliance->id; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('<?php echo trans('are_you_sure'); ?>');"><?php echo trans('delete'); ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center py-4"><?php echo trans('no_appliances_added'); ?></td></tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="4" class="px-6 py-3 text-right text-sm font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('total_daily_consumption'); ?></td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm font-bold text-gray-900"><?php echo number_format($data['project']->total_daily_consumption, 2); ?> Wh/day</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <div class="mt-6 text-right">
                <a href="<?php echo URLROOT; ?>/project/dimensioning/<?php echo $data['project']->id; ?>" class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700"><?php echo trans('proceed_to_dimensioning'); ?></a>
            </div>
        </div>
        
        <!-- Selected Components & Estimate -->
        <div class="mt-8 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold text-gray-800"><?php echo trans('project_estimate_selected_components'); ?></h2>
            <table class="min-w-full divide-y divide-gray-200 mt-4">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('type'); ?></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('component'); ?></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('quantity'); ?></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('unit_price'); ?></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('total_price'); ?></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($data['project_components'])): ?>
                        <?php foreach ($data['project_components'] as $p_component): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars(ucfirst($p_component->type)); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($p_component->brand . ' ' . $p_component->model); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $p_component->quantity; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$<?php echo number_format($p_component->unit_price, 2); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$<?php echo number_format($p_component->total_price, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center py-4"><?php echo trans('no_components_selected'); ?></td></tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="4" class="px-6 py-3 text-right text-sm font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('total_project_price'); ?></td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm font-bold text-gray-900">$<?php echo number_format($data['project']->total_price, 2); ?></td>
                    </tr>
                </tfoot>
            </table>
            <div class="mt-6 text-right">
                <a href="<?php echo URLROOT; ?>/maintenance/index/<?php echo $data['project']->id; ?>" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700"><?php echo trans('view_maintenance_schedule'); ?></a>
            </div>
        </div>

        <!-- File Attachments -->
        <div class="mt-8 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold text-gray-800"><?php echo trans('file_attachments'); ?></h2>
            
            <!-- File Upload Form -->
            <form action="<?php echo URLROOT; ?>/file/upload/<?php echo $data['project']->id; ?>" method="post" enctype="multipart/form-data" class="mt-4 border-b pb-4 mb-4">
                <?php \App\Core\CSRF::tokenField(); ?>
                <div class="flex items-center">
                    <input type="file" name="file" id="file" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-50 file:text-indigo-700
                        hover:file:bg-indigo-100" required>
                    <button type="submit" class="ml-4 bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700"><?php echo trans('upload_file'); ?></button>
                </div>
            </form>

            <!-- Files List -->
            <div class="mt-4">
                <?php if (!empty($data['project_files'])): ?>
                    <ul class="divide-y divide-gray-200">
                        <?php foreach ($data['project_files'] as $file): ?>
                            <li class="py-3 flex justify-between items-center">
                                <div>
                                    <a href="<?php echo URLROOT . '/' . htmlspecialchars($file->file_path); ?>" target="_blank" class="text-indigo-600 hover:text-indigo-800 font-medium"><?php echo htmlspecialchars($file->file_name); ?></a>
                                    <p class="text-sm text-gray-500"><?php echo trans('uploaded_by'); ?> <?php echo htmlspecialchars($file->uploader_name); ?> <?php echo trans('on'); ?> <?php echo date('M d, Y', strtotime($file->uploaded_at)); ?></p>
                                </div>
                                <a href="<?php echo URLROOT; ?>/file/delete/<?php echo $file->id; ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('<?php echo trans('are_you_sure_delete_file'); ?>');"><?php echo trans('delete'); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-center text-gray-500"><?php echo trans('no_files_attached'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
