<main class="flex-1 p-6 bg-gray-100">
    <div class="p-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800"><?php echo trans('projects'); ?></h1>
            <a href="<?php echo URLROOT; ?>/project/create" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700"><?php echo trans('new_project'); ?></a>
        </div>

        <div class="mt-8 bg-white p-6 rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('project_name'); ?></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('customer'); ?></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('region'); ?></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('status'); ?></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('total_consumption'); ?></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('total_price'); ?></th>
                        <th class="relative px-6 py-3"><span class="sr-only"><?php echo trans('actions'); ?></span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($data['projects'])): ?>
                        <?php foreach ($data['projects'] as $project): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($project->project_name); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($project->customer_name); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($project->region_name); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?php 
                                            switch ($project->status) {
                                                case 'Completed':
                                                    echo 'bg-green-100 text-green-800';
                                                    break;
                                                case 'In Progress':
                                                    echo 'bg-yellow-100 text-yellow-800';
                                                    break;
                                                case 'Cancelled':
                                                    echo 'bg-red-100 text-red-800';
                                                    break;
                                                default:
                                                    echo 'bg-gray-100 text-gray-800';
                                                    break;
                                            }
                                        ?>
                                    ">
                                        <?php echo trans(strtolower(str_replace(' ', '_', $project->status))); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo number_format($project->total_daily_consumption, 2); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$<?php echo number_format($project->total_price, 2); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="<?php echo URLROOT; ?>/project/show/<?php echo $project->id; ?>" class="text-indigo-600 hover:text-indigo-900"><?php echo trans('view'); ?></a>
                                    <a href="<?php echo URLROOT; ?>/project/delete/<?php echo $project->id; ?>" class="text-red-600 hover:text-red-900 ml-4" onclick="return confirm('<?php echo trans('are_you_sure'); ?>');"><?php echo trans('delete'); ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500"><?php echo trans('no_projects_found'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
