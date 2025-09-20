<main class="flex-1 p-6 bg-gray-100">
    <div class="p-6">
        <a href="<?php echo URLROOT; ?>/project/show/<?php echo $data['project']->id; ?>" class="text-indigo-600 hover:text-indigo-900 text-sm">
            &larr; <?php echo trans('back_to_project'); ?>
        </a>
        <h1 class="text-3xl font-bold text-gray-800 mt-2"><?php echo trans('maintenance_schedule'); ?></h1>
        <p class="text-gray-600"><?php echo trans('project'); ?>: <?php echo htmlspecialchars($data['project']->project_name); ?></p>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['success']; ?></span>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Add Task Form -->
        <div class="mt-8 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold text-gray-800"><?php echo trans('add_new_maintenance_task'); ?></h2>
            <form action="<?php echo URLROOT; ?>/maintenance/create/<?php echo $data['project']->id; ?>" method="post" class="mt-4">
                <?php \App\Core\CSRF::tokenField(); ?>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div class="md:col-span-2">
                        <label for="task_description" class="block text-sm font-medium text-gray-700"><?php echo trans('task_description'); ?></label>
                        <input type="text" name="task_description" id="task_description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm <?php echo (!empty($data['task_description_err'])) ? 'border-red-500' : ''; ?>">
                        <?php if (!empty($data['task_description_err'])): ?>
                            <p class="text-red-500 text-xs italic"><?php echo $data['task_description_err']; ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700"><?php echo trans('due_date'); ?></label>
                        <input type="date" name="due_date" id="due_date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm <?php echo (!empty($data['due_date_err'])) ? 'border-red-500' : ''; ?>">
                        <?php if (!empty($data['due_date_err'])): ?>
                            <p class="text-red-500 text-xs italic"><?php echo $data['due_date_err']; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <button type="submit" class="mt-4 bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700"><?php echo trans('add_task'); ?></button>
            </form>
        </div>

        <!-- Task List -->
        <div class="mt-8 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold text-gray-800"><?php echo trans('upcoming_tasks'); ?></h2>
            <table class="min-w-full divide-y divide-gray-200 mt-4">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('description'); ?></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('due_date'); ?></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('status'); ?></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('completed_on'); ?></th>
                        <th class="relative px-6 py-3"><span class="sr-only"><?php echo trans('actions'); ?></span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($data['tasks'])): ?>
                        <?php foreach ($data['tasks'] as $task): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($task->task_description); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('M d, Y', strtotime($task->due_date)); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo ($task->status === 'Completed') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                        <?php echo trans(htmlspecialchars($task->status)); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo $task->completed_at ? date('M d, Y', strtotime($task->completed_at)) : trans('not_applicable'); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <?php if ($task->status === 'Pending'): ?>
                                        <a href="<?php echo URLROOT; ?>/maintenance/updateStatus/<?php echo $task->id; ?>/completed" class="text-green-600 hover:text-green-900"><?php echo trans('mark_as_completed'); ?></a>
                                    <?php else: ?>
                                        <a href="<?php echo URLROOT; ?>/maintenance/updateStatus/<?php echo $task->id; ?>/pending" class="text-yellow-600 hover:text-yellow-900"><?php echo trans('mark_as_pending'); ?></a>
                                    <?php endif; ?>
                                    <a href="<?php echo URLROOT; ?>/maintenance/delete/<?php echo $task->id; ?>" class="text-red-600 hover:text-red-900 ml-4" onclick="return confirm('<?php echo trans('are_you_sure'); ?>');"><?php echo trans('delete'); ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500"><?php echo trans('no_maintenance_tasks_found'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
