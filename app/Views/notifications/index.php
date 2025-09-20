<?php require_once APPROOT . '/Views/layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6"><?php echo trans('notifications'); ?></h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-4 flex justify-end">
            <a href="<?php echo URLROOT; ?>/notifications/markAllAsRead" class="text-blue-500 hover:text-blue-700"><?php echo trans('mark_all_as_read'); ?></a>
        </div>
        <ul class="divide-y divide-gray-200">
            <?php if (empty($data['notifications'])): ?>
                <li class="p-4 text-center text-gray-500"><?php echo trans('you_have_no_notifications'); ?></li>
            <?php else: ?>
                <?php foreach ($data['notifications'] as $notification): ?>
                    <li class="p-4 <?php echo $notification->is_read ? 'bg-gray-50' : 'bg-blue-50 font-semibold'; ?>">
                        <div class="flex items-center justify-between">
                            <a href="<?php echo URLROOT; ?>/notifications/markAsRead/<?php echo $notification->id; ?>" class="block w-full">
                                <p class="text-gray-800"><?php echo htmlspecialchars($notification->message); ?></p>
                                <p class="text-sm text-gray-500 mt-1"><?php echo date('F j, Y, g:i a', strtotime($notification->created_at)); ?></p>
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>

<?php require_once APPROOT . '/Views/layouts/footer.php'; ?>
