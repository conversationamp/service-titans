<?php $__env->startSection('title', 'Profile'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">User Profile</li>
                    </ol>
                </div>
                <h4 class="page-title">User Profile</h4>
            </div>
            <!--end page-title-box-->
        </div>
        <!--end col-->
    </div>

    <style>
        .invalid-feedback {
            display: block;
        }
    </style>
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0"> General Settings</h4>
                    <form action="<?php echo e(route('profile.save')); ?>" method="POST" id="general_profile"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="last_name"> Name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" name="name" class="form-control" autocomplete="off"
                                            autofocus="autofocus" value="<?php echo e($user->name); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="text" name="email" class="form-control" autocomplete="off"
                                            autofocus="autofocus" value="<?php echo e($user->email); ?>">
                                    </div>
                                </div>

                                <?php if(auth()->user()->role == company_role()): ?>
                                    <div class="form-group row">
                                        <?php echo $__env->make('admin.components.form.input', [
                                            'column' => '12',
                                            'title' => 'Location',
                                            'name' => 'location',
                                            'default' => $user->location ?? '',
                                            'type' => 'text',
                                            'label_class' => 'location_id',
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                    
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            <button type="submit" class="btn btn-gradient-warning px-4 mt-0 mb-0"> Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <div class="input-group">
                                        <input type="file" name="image" class="form-control dropify" autocomplete="off"
                                            autofocus="autofocus" data-default-file="<?php echo e(auth()->user()->image ??''); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0"> Security </h4>
                    <form action="<?php echo e(route('password.save')); ?>" method="POST" id="">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="current_password">Current Password *</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" name="current_password" class="form-control" autocomplete="off"
                                    autofocus="autofocus">
                            </div>
                            <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <label for="new_password">New Password *</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control" autocomplete="off"
                                    autofocus="autofocus">
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Confirm Password *</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="confirm_password" class="form-control" autocomplete="off"
                                    autofocus="autofocus">
                            </div>
                            <?php $__errorArgs = ['confirm_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button type="submit" class="btn btn-gradient-warning px-4 mt-0 mb-0"> Change
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/profile/userprofile.blade.php ENDPATH**/ ?>