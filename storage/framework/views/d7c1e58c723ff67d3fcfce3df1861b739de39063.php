<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
    <!-- Page-Title -->
  <?php echo $__env->make('admin.components.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route($route.'.save')); ?>" method="POST" class="card-box" enctype="multipart/form-data">
                        <?php echo $__env->make('admin.'.$route.'.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make('admin.components.form.savebutton',['save'=>'Add New'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/user/add.blade.php ENDPATH**/ ?>