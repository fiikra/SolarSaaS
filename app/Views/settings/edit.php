<main class="flex-1 p-6 bg-gray-100">
    <div class="p-6 md:p-8">
        <header class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800"><?php echo trans('settings'); ?></h1>
            <p class="text-gray-600 mt-2 text-lg"><?php echo trans('adjust_calculation_parameters'); ?></p>
        </header>

        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                <p class="font-bold"><?php echo trans('success'); ?>!</p>
                <p><?php echo trans('settings_updated_success'); ?></p>
            </div>
        <?php endif; ?>

        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-6"><?php echo trans('calculation_parameters'); ?></h2>
            <form action="<?php echo URLROOT; ?>/settings/update" method="POST" class="space-y-8">
                <?php \App\Core\CSRF::tokenField(); ?>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Battery DoD -->
                    <div>
                        <label for="battery_dod" class="block text-sm font-bold text-gray-700 mb-1"><?php echo trans('battery_dod'); ?></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-battery-half text-gray-400"></i>
                            </div>
                            <input type="number" step="0.01" min="0" max="1" name="battery_dod" id="battery_dod" value="<?php echo htmlspecialchars($data['settings']->battery_dod); ?>" required class="w-full pl-10 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-solar-blue">
                        </div>
                        <p class="mt-2 text-sm text-gray-500"><?php echo trans('battery_dod_description'); ?></p>
                    </div>

                    <!-- System Loss Factor -->
                    <div>
                        <label for="system_loss_factor" class="block text-sm font-bold text-gray-700 mb-1"><?php echo trans('system_loss_factor'); ?></label>
                         <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-plug text-gray-400"></i>
                            </div>
                            <input type="number" step="0.01" min="0" max="1" name="system_loss_factor" id="system_loss_factor" value="<?php echo htmlspecialchars($data['settings']->system_loss_factor); ?>" required class="w-full pl-10 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-solar-blue">
                        </div>
                        <p class="mt-2 text-sm text-gray-500"><?php echo trans('system_loss_factor_description'); ?></p>
                    </div>

                    <!-- Days of Autonomy -->
                    <div>
                        <label for="days_of_autonomy" class="block text-sm font-bold text-gray-700 mb-1"><?php echo trans('days_of_autonomy'); ?></label>
                         <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-day text-gray-400"></i>
                            </div>
                            <input type="number" min="1" name="days_of_autonomy" id="days_of_autonomy" value="<?php echo htmlspecialchars($data['settings']->days_of_autonomy); ?>" required class="w-full pl-10 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-solar-blue">
                        </div>
                        <p class="mt-2 text-sm text-gray-500"><?php echo trans('days_of_autonomy_description'); ?></p>
                    </div>
                </div>

                <div class="flex justify-end pt-6 border-t">
                    <button type="submit" class="bg-solar-blue text-white font-bold py-3 px-6 rounded-lg hover:bg-opacity-90 transition-opacity shadow-md flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        <?php echo trans('save_settings'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
