<main class="flex-1 p-6 bg-gray-100">
    <div class="p-6 md:p-8">
        <header class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800"><?php echo trans('inventory_management'); ?></h1>
        </header>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"><?php echo trans('component'); ?></th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"><?php echo trans('type'); ?></th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"><?php echo trans('quantity'); ?></th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"><?php echo trans('low_stock_threshold'); ?></th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"><?php echo trans('last_updated'); ?></th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['inventory'] as $item): ?>
                        <tr class="<?php echo ($item->quantity !== null && $item->quantity <= $item->low_stock_threshold) ? 'bg-red-100' : ''; ?>">
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"><?php echo htmlspecialchars($item->brand . ' ' . $item->model); ?></p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"><?php echo htmlspecialchars($item->type); ?></p>
                            </td>
                            <form action="<?php echo URLROOT; ?>/inventory/update" method="post">
                                <?php \App\Core\CSRF::tokenField(); ?>
                                <input type="hidden" name="component_id" value="<?php echo $item->component_id; ?>">
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <input type="number" name="quantity" value="<?php echo $item->quantity ?? 0; ?>" class="w-24 form-input">
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <input type="number" name="low_stock_threshold" value="<?php echo $item->low_stock_threshold ?? 10; ?>" class="w-24 form-input">
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap"><?php echo $item->last_updated ? date('Y-m-d H:i', strtotime($item->last_updated)) : trans('not_applicable'); ?></p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"><?php echo trans('update'); ?></button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
