<h1 class="text-3xl text-black pb-6"><?php echo trans('dashboard'); ?></h1>

<div class="flex flex-wrap">
    <!-- Total Projects -->
    <div class="w-full md:w-1/2 xl:w-1/3 p-3">
        <div class="bg-white border-b-4 border-blue-500 rounded-lg shadow-lg p-5">
            <div class="flex flex-row items-center">
                <div class="flex-shrink pr-4">
                    <div class="rounded-full p-5 bg-blue-500"><i class="fas fa-tasks fa-2x fa-inverse"></i></div>
                </div>
                <div class="flex-1 text-right md:text-center">
                    <h5 class="font-bold uppercase text-gray-600"><?php echo trans('total_projects'); ?></h5>
                    <h3 class="font-bold text-3xl"><?php echo $data['totalProjects']; ?></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Pending Invoices -->
    <div class="w-full md:w-1/2 xl:w-1/3 p-3">
        <div class="bg-white border-b-4 border-yellow-500 rounded-lg shadow-lg p-5">
            <div class="flex flex-row items-center">
                <div class="flex-shrink pr-4">
                    <div class="rounded-full p-5 bg-yellow-500"><i class="fas fa-file-invoice-dollar fa-2x fa-inverse"></i></div>
                </div>
                <div class="flex-1 text-right md:text-center">
                    <h5 class="font-bold uppercase text-gray-600"><?php echo trans('pending_invoices'); ?></h5>
                    <h3 class="font-bold text-3xl"><?php echo $data['pendingInvoices']; ?></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Paid Invoices -->
    <div class="w-full md:w-1/2 xl:w-1/3 p-3">
        <div class="bg-white border-b-4 border-green-500 rounded-lg shadow-lg p-5">
            <div class="flex flex-row items-center">
                <div class="flex-shrink pr-4">
                    <div class="rounded-full p-5 bg-green-500"><i class="fas fa-check-circle fa-2x fa-inverse"></i></div>
                </div>
                <div class="flex-1 text-right md:text-center">
                    <h5 class="font-bold uppercase text-gray-600"><?php echo trans('paid_invoices'); ?></h5>
                    <h3 class="font-bold text-3xl"><?php echo $data['paidInvoices']; ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="w-full mt-12">
    <p class="text-xl pb-3 flex items-center">
        <i class="fas fa-list mr-3"></i> <?php echo trans('recent_projects'); ?>
    </p>
    <div class="bg-white overflow-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm"><?php echo trans('project_name'); ?></th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm"><?php echo trans('customer'); ?></th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm"><?php echo trans('date'); ?></th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm"></th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <?php foreach($data['recentProjects'] as $project): ?>
                    <tr>
                        <td class="text-left py-3 px-4"><?php echo htmlspecialchars($project->project_name); ?></td>
                        <td class="text-left py-3 px-4"><?php echo htmlspecialchars($project->customer_name); ?></td>
                        <td class="text-left py-3 px-4"><?php echo date('Y-m-d', strtotime($project->created_at)); ?></td>
                        <td class="text-left py-3 px-4"><a class="hover:text-blue-500" href="<?php echo URLROOT . '/project/show/' . $project->id; ?>"><?php echo trans('view'); ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

