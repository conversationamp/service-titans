<div class="leftbar-profile p-3 w-100">
    <div class="media position-relative">
        <div class="leftbar ">
            <img src="<?php echo e(asset(auth()->user()->image)); ?>" alt="" class="thumb-md rounded-circle" onerror="this.src='<?php echo e(asset('assets/images/sabi.jpg')); ?>'">
        </div>
        <div class="media-body align-self-center text-truncate ml-3">
            <h5 class="mt-0 mb-1 font-weight-semibold"><?php echo e(auth()->user()->name); ?></h5>
            <?php if(auth()->user()->role==0): ?>
            <p class="text-uppercase mb-0 font-12">Super Admin  </p>
            <?php elseif(auth()->user()->role==1): ?>
            <p class="text-uppercase mb-0 font-12"> Company Admin  </p>
           <?php else: ?>
            <p class="text-uppercase mb-0 font-12">  User </p>
            <?php endif; ?>
        </div><!--end media-body-->
    </div>
</div>
<?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/components/left-nav-header.blade.php ENDPATH**/ ?>