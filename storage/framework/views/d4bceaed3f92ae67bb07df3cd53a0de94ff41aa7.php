<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
    <?php
        if (isset($id) && !is_null($id)) {
            $id = $id;
        } else {
            $id = null;
        }
    ?>
    <!-- Page-Title -->
    <?php echo $__env->make('admin.components.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-md-12 mx-auto">
            <form action="<?php echo e(route($route . '.save')); ?>" method="POST" class="card-box" enctype="multipart/form-data"
                id="sync_setting_save_form">
                <?php echo csrf_field(); ?>
                <?php echo $__env->make('admin.sync-settings.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </form>

        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>
    <?php echo $__env->make('admin.sync-settings.formscript', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/sync-settings/add.blade.php ENDPATH**/ ?>