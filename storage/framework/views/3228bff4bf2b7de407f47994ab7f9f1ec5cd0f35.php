
<?php $__env->startSection('title', 'General Settings'); ?>
<?php $__env->startSection('content'); ?>
    
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">General Settings</li>
                    </ol>
                </div>
                <h4 class="page-title">General Settings</h4>
            </div>
            <!--end page-title-box-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
    <!-- end page title end breadcrumb -->

    <div class="row">

        <?php if(auth()->user()->role == 1 || auth()->user()->role == 0): ?>
            <div class="col-md-6">
                <div class="card">
                    <h4 class="p-3"> Genaral Settings </h4>
                    <div class="card-body">
                        <form action="<?php echo e(route('setting.save')); ?>" method="POST" class="card-box"
                            enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <label for="company_name"> Company Name </label>
                                <input type="text" class="form-control" name="company_name" id="company_name"
                                    value="<?php echo e(get_values_by_id('company_name', login_id())); ?>"
                                    placeholder="Enter company name ">
                            </div>

                            <div class="form-group">
                                <label for="company_email"> Company Name </label>
                                <input type="text" class="form-control" name="company_email" id="company_name"
                                    value="<?php echo e(get_values_by_id('company_email', login_id())); ?>"
                                    placeholder="Enter company email ">
                            </div>

                            
                            <div class="form-group">
                                <label for="company_logo"> Company Logo </label>
                                <input type="file" class="form-control dropify" name="company_logo" id="company_logo"
                                    data-default-file="<?php echo e(asset(get_values_by_id('company_logo', login_id()))); ?>">
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <input type="submit" class="btn btn-info" value="Save Settings">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/settings/general.blade.php ENDPATH**/ ?>