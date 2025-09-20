<?php use App\Core\Auth; ?>
<div class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out">
    <a href="<?php echo URLROOT; ?>/dashboard" class="text-white text-2xl font-semibold uppercase hover:text-gray-300">SolarSaaS</a>
    <nav>
        <a href="<?php echo URLROOT; ?>/dashboard" class="flex items-center active-nav-link text-white py-4 pl-6 nav-item">
    <i class="fas fa-tachometer-alt mr-3"></i>
    <?php echo trans('dashboard'); ?>
</a>
<a href="<?php echo URLROOT; ?>/projects" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
    <i class="fas fa-sticky-note mr-3"></i>
    <?php echo trans('projects'); ?>
</a>
<a href="<?php echo URLROOT; ?>/invoices" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
    <i class="fas fa-file-invoice-dollar mr-3"></i>
    <?php echo trans('invoices'); ?>
</a>
<a href="<?php echo URLROOT; ?>/subscriptions" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
    <i class="fas fa-credit-card mr-3"></i>
    <?php echo trans('subscriptions'); ?>
</a>
<a href="<?php echo URLROOT; ?>/clients" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
    <i class="fas fa-users mr-3"></i>
    <?php echo trans('clients'); ?>
</a>
<a href="<?php echo URLROOT; ?>/account" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
    <i class="fas fa-user mr-3"></i>
    <?php echo trans('account'); ?>
</a>
<a href="<?php echo URLROOT; ?>/settings" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
    <i class="fas fa-cogs mr-3"></i>
    <?php echo trans('settings'); ?>
</a>
<a href="<?php echo URLROOT; ?>/logout" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
    <i class="fas fa-sign-out-alt mr-3"></i>
    <?php echo trans('logout'); ?>
</a>
    </nav>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function fetchUnreadNotifications() {
            fetch('<?php echo URLROOT; ?>/notifications/getUnread')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notification-badge');
                    if (data.length > 0) {
                        badge.textContent = data.length;
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error fetching notifications:', error));
        }

        fetchUnreadNotifications();
        setInterval(fetchUnreadNotifications, 60000); // Refresh every 60 seconds
    });
</script>
