<main class="flex-1 p-6 bg-gray-100">
    <div class="p-6 md:p-8">
        <header class="mb-8">
            <a href="<?php echo URLROOT; ?>/components" class="text-solar-blue hover:text-blue-800 font-medium text-sm">
                <i class="fas fa-arrow-left mr-2"></i><?php echo trans('back_to_catalog'); ?>
            </a>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2"><?php echo ($data['action'] === 'create') ? trans('component_form_title_create') : trans('component_form_title_edit'); ?></h1>
            <p class="text-gray-600 mt-2 text-lg"><?php echo trans('component_form_description'); ?></p>
        </header>

        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md">
            <form action="<?php echo URLROOT; ?>/component/<?php echo ($data['action'] === 'create') ? 'store' : 'update/' . $data['component']->id; ?>" method="POST" class="space-y-8">
                <?php \App\Core\CSRF::tokenField(); ?>
                
                <!-- General Information -->
                <fieldset>
                    <legend class="text-xl font-bold text-gray-800 border-b border-gray-200 pb-2 mb-4"><?php echo trans('general_information'); ?></legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="type" class="block text-sm font-bold text-gray-700 mb-1"><?php echo trans('component_type'); ?></label>
                            <select name="type" id="type" required class="w-full p-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-solar-blue">
                                <option value="panel" <?php echo (isset($data['component']) && $data['component']->type == 'panel') ? 'selected' : ''; ?>><?php echo trans('solar_panel'); ?></option>
                                <option value="battery" <?php echo (isset($data['component']) && $data['component']->type == 'battery') ? 'selected' : ''; ?>><?php echo trans('battery'); ?></option>
                                <option value="inverter" <?php echo (isset($data['component']) && $data['component']->type == 'inverter') ? 'selected' : ''; ?>><?php echo trans('inverter'); ?></option>
                                <option value="controller" <?php echo (isset($data['component']) && $data['component']->type == 'controller') ? 'selected' : ''; ?>><?php echo trans('charge_controller'); ?></option>
                            </select>
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-bold text-gray-700 mb-1"><?php echo trans('price'); ?> ($)</label>
                            <input type="number" step="0.01" name="price" id="price" value="<?php echo $data['component']->price ?? ''; ?>" required placeholder="<?php echo trans('price_placeholder'); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-solar-blue">
                        </div>
                        <div>
                            <label for="brand" class="block text-sm font-bold text-gray-700 mb-1"><?php echo trans('brand'); ?></label>
                            <input type="text" name="brand" id="brand" value="<?php echo $data['component']->brand ?? ''; ?>" required placeholder="<?php echo trans('brand_placeholder'); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-solar-blue">
                        </div>
                        <div>
                            <label for="model" class="block text-sm font-bold text-gray-700 mb-1"><?php echo trans('model'); ?></label>
                            <input type="text" name="model" id="model" value="<?php echo $data['component']->model ?? ''; ?>" required placeholder="<?php echo trans('model_placeholder'); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-solar-blue">
                        </div>
                    </div>
                </fieldset>

                <!-- Dynamic Specifications -->
                <fieldset>
                    <legend class="text-xl font-bold text-gray-800 border-b border-gray-200 pb-2 mb-4"><?php echo trans('specifications'); ?></legend>
                    <div id="specs-fields" class="space-y-6">
                        <!-- Panel Specs -->
                        <div id="panel-specs" class="spec-group">
                            <label for="spec_power_watt" class="block text-sm font-bold text-gray-700 mb-1"><?php echo trans('power_wp'); ?></label>
                            <input type="number" name="spec_power_watt" id="spec_power_watt" value="<?php echo $data['specs']['power_watt'] ?? ''; ?>" placeholder="<?php echo trans('power_wp_placeholder'); ?>" class="w-full md:w-1/2 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-solar-blue">
                        </div>
                        <!-- Battery Specs -->
                        <div id="battery-specs" class="spec-group grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="spec_capacity_ah" class="block text-sm font-bold text-gray-700 mb-1"><?php echo trans('capacity_ah'); ?></label>
                                <input type="number" name="spec_capacity_ah" id="spec_capacity_ah" value="<?php echo $data['specs']['capacity_ah'] ?? ''; ?>" placeholder="<?php echo trans('capacity_ah_placeholder'); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-solar-blue">
                            </div>
                            <div>
                                <label for="spec_voltage_battery" class="block text-sm font-bold text-gray-700 mb-1"><?php echo trans('voltage_v'); ?></label>
                                <input type="number" name="spec_voltage" id="spec_voltage_battery" value="<?php echo $data['specs']['voltage'] ?? ''; ?>" placeholder="<?php echo trans('voltage_v_placeholder_battery'); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-solar-blue">
                            </div>
                        </div>
                        <!-- Inverter Specs -->
                        <div id="inverter-specs" class="spec-group grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="spec_power_watt_inverter" class="block text-sm font-bold text-gray-700 mb-1"><?php echo trans('power_w'); ?></label>
                                <input type="number" name="spec_power_watt" id="spec_power_watt_inverter" value="<?php echo $data['specs']['power_watt'] ?? ''; ?>" placeholder="<?php echo trans('power_w_placeholder_inverter'); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-solar-blue">
                            </div>
                            <div>
                                <label for="spec_voltage_inverter" class="block text-sm font-bold text-gray-700 mb-1"><?php echo trans('voltage_v'); ?></label>
                                <input type="number" name="spec_voltage" id="spec_voltage_inverter" value="<?php echo $data['specs']['voltage'] ?? ''; ?>" placeholder="<?php echo trans('voltage_v_placeholder_inverter'); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-solar-blue">
                            </div>
                        </div>
                        <!-- Controller Specs -->
                        <div id="controller-specs" class="spec-group grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="spec_max_current_amp" class="block text-sm font-bold text-gray-700 mb-1"><?php echo trans('max_current_a'); ?></label>
                                <input type="number" name="spec_max_current_amp" id="spec_max_current_amp" value="<?php echo $data['specs']['max_current_amp'] ?? ''; ?>" placeholder="<?php echo trans('max_current_a_placeholder'); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-solar-blue">
                            </div>
                            <div>
                                <label for="spec_voltage_controller" class="block text-sm font-bold text-gray-700 mb-1"><?php echo trans('voltage_v'); ?></label>
                                <input type="number" name="spec_voltage" id="spec_voltage_controller" value="<?php echo $data['specs']['voltage'] ?? ''; ?>" placeholder="<?php echo trans('voltage_v_placeholder_controller'); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-solar-blue">
                            </div>
                        </div>
                    </div>
                </fieldset>

                <!-- Form Actions -->
                <div class="flex justify-end pt-4 border-t">
                    <a href="<?php echo URLROOT; ?>/components" class="text-gray-600 font-medium py-3 px-5 rounded-lg mr-4 hover:bg-gray-100"><?php echo trans('cancel'); ?></a>
                    <button type="submit" class="bg-solar-blue text-white font-bold py-3 px-6 rounded-lg hover:bg-opacity-90 transition-opacity shadow-md">
                        <?php echo trans('save_component'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const specGroups = {
                panel: document.getElementById('panel-specs'),
                battery: document.getElementById('battery-specs'),
                inverter: document.getElementById('inverter-specs'),
                controller: document.getElementById('controller-specs')
            };
            const allInputs = document.querySelectorAll('.spec-group input');

            function toggleSpecFields() {
                const selectedType = typeSelect.value;
                
                // Disable all spec inputs first
                allInputs.forEach(input => input.disabled = true);
                
                // Hide all groups
                for (const key in specGroups) {
                    if (specGroups[key]) {
                        specGroups[key].style.display = 'none';
                    }
                }

                // Show the selected group and enable its inputs
                if (specGroups[selectedType]) {
                    specGroups[selectedType].style.display = 'grid';
                    specGroups[selectedType].querySelectorAll('input').forEach(input => input.disabled = false);
                }
            }

            typeSelect.addEventListener('change', toggleSpecFields);
            toggleSpecFields(); // Initial call
        });
    </script>
</main>
