<?php if(session('success')): ?>
<script>
    toastr.success("<?php echo e(session('success')); ?>", {
        timeOut: 10000
    })

</script>
<?php endif; ?>
<?php if(session('error')): ?>
<script>
    toastr.danger("<?php echo e(session('error')); ?>")

</script>
<?php endif; ?><?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/layouts/message.blade.php ENDPATH**/ ?>