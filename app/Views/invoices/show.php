<main class="flex-1 p-6 bg-gray-100">
    <!-- Page Heading -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800"><?php echo trans('invoice_number'); ?><?php echo htmlspecialchars($data['invoice']->id); ?></h1>
        <a href="<?php echo URLROOT; ?>/invoices/pdf/<?php echo $data['invoice']->id; ?>" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            <?php echo trans('generate_pdf'); ?>
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800"><?php echo trans('invoice_details'); ?></h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p><strong><?php echo trans('invoice_id'); ?>:</strong> <?php echo htmlspecialchars($data['invoice']->id); ?></p>
                    <p><strong><?php echo trans('client'); ?>:</strong> <?php echo htmlspecialchars($data['invoice']->company_name); ?></p>
                    <p><strong><?php echo trans('subscription'); ?>:</strong> <?php echo htmlspecialchars($data['invoice']->plan_name); ?></p>
                </div>
                <div class="text-left md:text-right">
                    <p><strong><?php echo trans('issue_date'); ?>:</strong> <?php echo htmlspecialchars($data['invoice']->issue_date); ?></p>
                    <p><strong><?php echo trans('due_date'); ?>:</strong> <?php echo htmlspecialchars($data['invoice']->due_date); ?></p>
                    <p><strong><?php echo trans('status'); ?>:</strong> <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo getStatusBadgeClass($data['invoice']->status); ?>"><?php echo trans(strtolower(htmlspecialchars($data['invoice']->status))); ?></span></p>
                </div>
            </div>
            <hr class="my-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900"><?php echo trans('invoice_items'); ?></h3>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('description'); ?></th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('quantity'); ?></th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('unit_price'); ?></th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo trans('total'); ?></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($data['items'] as $item) : ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($item->description); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($item->quantity); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$<?php echo number_format($item->unit_price, 2); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">$<?php echo number_format($item->quantity * $item->unit_price, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-6 flex justify-end">
                <div class="w-full max-w-xs">
                    <div class="flex justify-between py-2">
                        <span class="text-sm font-medium text-gray-500"><?php echo trans('subtotal'); ?></span>
                        <span class="text-sm text-gray-900">$<?php echo number_format($data['invoice']->total_amount, 2); ?></span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-sm font-medium text-gray-500"><?php echo trans('tax'); ?> (0%)</span>
                        <span class="text-sm text-gray-900">$0.00</span>
                    </div>
                    <div class="flex justify-between py-2 border-t-2 border-gray-200">
                        <span class="text-base font-bold text-gray-900"><?php echo trans('total'); ?></span>
                        <span class="text-base font-bold text-gray-900">$<?php echo number_format($data['invoice']->total_amount, 2); ?></span>
                    </div>
                </div>
            </div>
            <hr class="my-6">
            <div class="flex justify-end">
                 <?php if ($data['invoice']->status != 'paid') : ?>
                    <form action="<?php echo URLROOT; ?>/invoices/markAsPaid/<?php echo $data['invoice']->id; ?>" method="post">
                        <?php \App\Core\CSRF::tokenField(); ?>
                        <button type="submit" class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700"><?php echo trans('mark_as_paid'); ?></button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php
function getStatusBadgeClass($status)
{
    switch (strtolower($status)) {
        case 'paid':
            return 'bg-green-100 text-green-800';
        case 'sent':
            return 'bg-blue-100 text-blue-800';
        case 'overdue':
            return 'bg-red-100 text-red-800';
        case 'draft':
            return 'bg-gray-100 text-gray-800';
        case 'void':
            return 'bg-yellow-100 text-yellow-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
}
?>
