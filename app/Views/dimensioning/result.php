<main class="flex-1 p-6 bg-gray-100">
    <div class="p-6 md:p-8">
        <header class="mb-8">
            <a href="<?php echo URLROOT; ?>/project/show/<?php echo $data['project']->id; ?>" class="text-solar-blue hover:text-blue-800 font-medium text-sm">
                <i class="fas fa-arrow-left mr-2"></i><?php echo trans('back_to_project'); ?>
            </a>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2"><?php echo trans('system_dimensioning'); ?></h1>
            <p class="text-gray-600 mt-2 text-lg"><?php echo trans('calculated_requirements_for'); ?> <span class="font-semibold"><?php echo htmlspecialchars($data['project']->project_name); ?></span></p>
        </header>

        <!-- Calculated Requirements -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-md font-semibold text-gray-500"><?php echo trans('total_energy_per_day'); ?></h3>
                <p class="text-3xl font-bold text-solar-blue mt-2" id="total_energy_needed"><?php echo number_format($data['total_energy_needed'], 0); ?> Wh</p>
                <p class="text-sm text-gray-500 mt-1"><?php echo str_replace('{0}', ($data['settings']->system_loss_factor * 100), trans('includes_loss_factor')); ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-md font-semibold text-gray-500"><?php echo trans('peak_panel_power'); ?></h3>
                <p class="text-3xl font-bold text-solar-blue mt-2" id="peak_power_required"><?php echo number_format($data['peak_power_required'], 0); ?> Wp</p>
                <p class="text-sm text-gray-500 mt-1"><?php echo str_replace('{0}', $data['project']->psh, trans('based_on_psh')); ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-md font-semibold text-gray-500"><?php echo trans('battery_capacity'); ?></h3>
                <p class="text-3xl font-bold text-solar-blue mt-2" id="battery_capacity_ah"><?php echo number_format($data['battery_capacity'], 0); ?> Ah</p>
                <p class="text-sm text-gray-500 mt-1"><?php echo str_replace(['{0}', '{1}'], [$data['settings']->days_of_autonomy, 12], trans('days_autonomy_at_voltage')); ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-md font-semibold text-gray-500"><?php echo trans('inverter_size'); ?></h3>
                <p class="text-3xl font-bold text-solar-blue mt-2" id="inverter_size_w"><?php echo number_format($data['inverter_size'], 0); ?> W</p>
                <p class="text-sm text-gray-500 mt-1"><?php echo trans('continuous_power'); ?></p>
            </div>
        </div>

        <!-- Component Selection Form -->
        <div class="bg-white p-8 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-2"><?php echo trans('select_system_components'); ?></h2>
            <p class="text-gray-600 mb-6"><?php echo trans('select_components_description'); ?></p>
            
            <form action="<?php echo URLROOT; ?>/dimensioning/selectComponents/<?php echo $data['project']->id; ?>" method="POST" class="space-y-8">
                <?php \App\Core\CSRF::tokenField(); ?>
                
                <?php
                function renderComponentSelector($type, $title, $items, $suggestionId) {
                    $hasItems = !empty($items);
                ?>
                <fieldset class="border border-gray-200 p-4 rounded-lg">
                    <legend class="text-lg font-bold text-gray-700 px-2"><?php echo $title; ?></legend>
                    <?php if ($hasItems): ?>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                        <div class="md:col-span-2">
                            <label for="<?php echo $type; ?>_select" class="block text-sm font-medium text-gray-700 mb-1"><?php echo trans('select_a_model'); ?></label>
                            <select id="<?php echo $type; ?>_select" name="component_selections[<?php echo $type; ?>][id]" class="component-select w-full p-3 border border-gray-300 bg-white rounded-lg focus:ring-2 focus:ring-solar-blue" data-type="<?php echo $type; ?>">
                                <option value=""><?php echo str_replace('{0}', $type, trans('choose_component')); ?></option>
                                <?php foreach($items as $item): ?>
                                    <option value="<?php echo $item->id; ?>" data-specs='<?php echo htmlspecialchars($item->specs, ENT_QUOTES, 'UTF-8'); ?>'><?php echo htmlspecialchars($item->brand . ' ' . $item->model); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="<?php echo $type; ?>_quantity" class="block text-sm font-medium text-gray-700 mb-1"><?php echo trans('quantity'); ?></label>
                            <div class="flex items-center">
                                <input type="number" name="component_selections[<?php echo $type; ?>][quantity]" id="<?php echo $type; ?>_quantity" min="0" class="final-quantity w-24 p-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-solar-blue" placeholder="0">
                                <div id="<?php echo $suggestionId; ?>" class="ml-4 text-sm"></div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <p class="text-center text-gray-500 py-4"><?php echo str_replace('{0}', $type, trans('no_components_in_catalog')); ?> <a href="<?php echo URLROOT; ?>/component/create" class="text-solar-blue font-medium"><?php echo trans('add_one_now'); ?></a>.</p>
                    <?php endif; ?>
                </fieldset>
                <?php } ?>

                <?php renderComponentSelector('panel', trans('solar_panels'), $data['panels'], 'panel_suggestion'); ?>
                <?php renderComponentSelector('battery', trans('batteries'), $data['batteries'], 'battery_suggestion'); ?>
                <?php renderComponentSelector('inverter', trans('inverter'), $data['inverters'], 'inverter_suggestion'); ?>
                <?php renderComponentSelector('controller', trans('charge_controller'), $data['controllers'], 'controller_suggestion'); ?>

                <div class="flex justify-end pt-4 border-t">
                    <a href="<?php echo URLROOT; ?>/project/show/<?php echo $data['project']->id; ?>" class="text-gray-600 font-medium py-3 px-5 rounded-lg mr-4 hover:bg-gray-100"><?php echo trans('cancel'); ?></a>
                    <button type="submit" class="bg-solar-blue text-white font-bold py-3 px-6 rounded-lg hover:bg-opacity-90 transition-opacity shadow-md">
                        <?php echo trans('save_components'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const requirements = {
            panel: parseFloat(document.getElementById('peak_power_required').textContent) || 0,
            battery: parseFloat(document.getElementById('battery_capacity_ah').textContent) || 0,
            inverter: parseFloat(document.getElementById('inverter_size_w').textContent) || 0,
            controller: 0 // Controller logic might be more complex, e.g., based on panel current
        };

        document.querySelectorAll('.component-select').forEach(select => {
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const type = this.dataset.type;
                const suggestionEl = document.getElementById(`${type}_suggestion`);
                const quantityInput = document.getElementById(`${type}_quantity`);

                if (!selectedOption.value) {
                    suggestionEl.innerHTML = '';
                    quantityInput.value = '';
                    return;
                }

                const specs = JSON.parse(selectedOption.dataset.specs);
                let suggestion = 0;
                let unit = '';

                switch (type) {
                    case 'panel':
                        const panelPower = parseFloat(specs.power_watt);
                        if (panelPower > 0) {
                            suggestion = Math.ceil(requirements.panel / panelPower);
                            unit = 'panels';
                        }
                        break;
                    case 'battery':
                        const batteryCapacity = parseFloat(specs.capacity_ah);
                        if (batteryCapacity > 0) {
                            suggestion = Math.ceil(requirements.battery / batteryCapacity);
                            unit = 'batteries';
                        }
                        break;
                    case 'inverter':
                         const inverterPower = parseFloat(specs.power_watt);
                        if (inverterPower > 0) {
                            suggestion = (requirements.inverter <= inverterPower) ? 1 : Math.ceil(requirements.inverter / inverterPower);
                            unit = 'inverters';
                        }
                        break;
                    case 'controller':
                        // Placeholder for controller logic
                        suggestion = 1;
                        unit = 'controllers';
                        break;
                }

                if (suggestion > 0) {
                    suggestionEl.innerHTML = `<span class="font-semibold text-green-600">${"<?php echo trans('suggest_quantity'); ?>".replace('{0}', suggestion).replace('{1}', unit)}</span>`;
                    quantityInput.value = suggestion;
                } else {
                    suggestionEl.innerHTML = `<span class="text-red-500"><?php echo trans('invalid_spec'); ?></span>`;
                    quantityInput.value = '';
                }
            });
        });
    });
    </script>
</main>
