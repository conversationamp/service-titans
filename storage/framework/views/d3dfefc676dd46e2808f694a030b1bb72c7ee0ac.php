<ul class="metismenu left-sidenav-menu slimscroll">

    <li class="leftbar-menu-item">
        <a href="<?php echo e(url('/')); ?>" class="menu-link">
            <i data-feather="pie-chart" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <?php if(auth()->user()->role == 0): ?>
        <?php echo $__env->make('admin.components.navs.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <?php echo $__env->make('admin.components.navs.company', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</ul>
<?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/components/nav.blade.php ENDPATH**/ ?>