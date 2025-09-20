<div class="p-6 md:p-8">
    <header class="flex flex-col md:flex-row justify-between md:items-center mb-8 print:hidden">
        <div>
            <a href="<?php echo URLROOT; ?>/project/show/<?php echo $data['project']->id; ?>" class="text-solar-blue hover:text-blue-800 font-medium text-sm">
                <i class="fas fa-arrow-left mr-2"></i>Back to Project
            </a>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Maintenance Plan</h1>
            <p class="text-gray-600 mt-2 text-lg">Recommended schedule for project: <span class="font-semibold"><?php echo htmlspecialchars($data['project']->project_name); ?></span></p>
        </div>
        <button onclick="window.print()" class="mt-4 md:mt-0 bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors flex items-center shadow-md">
            <i class="fas fa-print mr-2"></i>Print Plan
        </button>
    </header>

    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-12 rounded-xl shadow-lg">
        <div class="print:block hidden mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800">Maintenance Plan</h1>
            <p class="text-gray-600">Project: <?php echo htmlspecialchars($data['project']->project_name); ?></p>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Recommended Maintenance Schedule</h2>
        
        <?php 
            $groupedTasks = [];
            foreach ($data['tasks'] as $task) {
                $groupedTasks[$task->frequency][] = $task;
            }
            $frequencies = ['monthly', 'quarterly', 'biannual', 'annual'];
        ?>

        <div class="space-y-8">
            <?php foreach ($frequencies as $freq): ?>
                <?php if (isset($groupedTasks[$freq])): ?>
                    <div>
                        <h3 class="text-xl font-semibold text-solar-blue border-b-2 border-solar-blue/30 pb-2 mb-4">
                            <?php echo ucfirst($freq); ?> Tasks
                        </h3>
                        <ul class="space-y-3">
                            <?php foreach ($groupedTasks[$freq] as $task): ?>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <div>
                                        <span class="font-bold text-gray-700">[<?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $task->component_type))); ?>]</span>
                                        <p class="text-gray-600"><?php echo htmlspecialchars($task->task_description); ?></p>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<style>
    @media print {
        .print\\:hidden { display: none; }
        .print\\:block { display: block; }
    }
</style>
