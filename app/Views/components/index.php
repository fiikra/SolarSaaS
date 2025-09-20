<main class="flex-1 p-6 bg-gray-100">
    <div class="p-6 md:p-8">
        <header class="flex flex-col md:flex-row justify-between md:items-center mb-8">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800"><?php echo trans('material_catalog'); ?></h1>
                <p class="text-gray-600 mt-2 text-lg"><?php echo trans('manage_components'); ?></p>
            </div>
            <a href="<?php echo URLROOT; ?>/component/create" class="mt-4 md:mt-0 bg-solar-blue text-white font-bold py-3 px-5 rounded-lg hover:bg-opacity-90 transition-opacity flex items-center shadow-md">
                <i class="fas fa-plus mr-2"></i> <?php echo trans('add_new_component'); ?>
            </a>
        </header>

        <div class="bg-white p-6 rounded-xl shadow-md">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider"><?php echo trans('type'); ?></th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider"><?php echo trans('brand_model'); ?></th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider"><?php echo trans('specifications'); ?></th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider"><?php echo trans('price'); ?></th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only"><?php echo trans('actions'); ?></span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (!empty($data['components'])): ?>
                            <?php foreach ($data['components'] as $component): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            <?php echo htmlspecialchars(ucfirst($component->type)); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900"><?php echo htmlspecialchars($component->brand); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($component->model); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <?php 
                                            $specs = json_decode($component->specs, true);
                                            $specItems = [];
                                            foreach ($specs as $key => $value) {
                                                $specItems[] = '<strong>' . htmlspecialchars(ucwords(str_replace('_', ' ', $key))) . ':</strong> ' . htmlspecialchars($value);
                                            }
                                            echo implode(' | ', $specItems);
                                        ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-800">$<?php echo number_format($component->price, 2); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="<?php echo URLROOT; ?>/component/edit/<?php echo $component->id; ?>" class="text-solar-blue hover:text-blue-800"><?php echo trans('edit'); ?></a>
                                        <a href="<?php echo URLROOT; ?>/component/delete/<?php echo $component->id; ?>" class="text-red-600 hover:text-red-800 ml-4" onclick="return confirm('<?php echo trans('are_you_sure_delete_component'); ?>');"><?php echo trans('delete'); ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">
                                    <div class="text-center py-12 px-6">
                                        <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                                        <h3 class="text-lg font-medium text-gray-800"><?php echo trans('catalog_empty'); ?></h3>
                                        <p class="text-gray-500"><?php echo trans('get_started_adding_component'); ?></p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
