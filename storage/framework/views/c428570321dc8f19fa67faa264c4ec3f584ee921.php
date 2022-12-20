
<li class="has-submenu leftbar-menu-item">
    <a href="#" class="menu-link">
        <i data-feather="settings" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
        <span> Settings </span>
    </a>
    <ul class="submenu childnav">
        <li><a href="<?php echo e(route('setting.general')); ?>"> General Settings </a></li>
        <?php if(auth()->user()->role == 1): ?>
            <li><a href="<?php echo e(route('setting.titan')); ?>"> Service Titans Settings </a></li>
        <?php endif; ?>
        <li><a href="<?php echo e(route('setting.index')); ?>"> Auth Settings </a></li>
        <?php if(auth()->user()->role == 1): ?>
        <li><a href="<?php echo e(route('sync-settings.list')); ?>"> Sync Settings </a></li>
        <?php endif; ?>
    </ul>
</li>

<?php if(auth()->user()->role == 1): ?>
    <li class="leftbar-menu-item">
        <a href="<?php echo e(route('sync-settings.get-default')); ?>" class="menu-link">
            <i data-feather="users" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
            <span> Make Default Setting </span>
        </a>
    </li>


    <li class="has-submenu leftbar-menu-item">
        <a href="#" class="menu-link">
            <i data-feather="settings" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
            <span> Logs </span>
        </a>
        <ul class="submenu childnav">
            <li><a href="<?php echo e(route('log.contact')); ?>"> Contacts </a></li>
            <li><a href="<?php echo e(route('log.opportunity')); ?>"> Opportunities </a></li>
        </ul>
    </li>
<?php endif; ?>
<?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/components/navs/company.blade.php ENDPATH**/ ?>