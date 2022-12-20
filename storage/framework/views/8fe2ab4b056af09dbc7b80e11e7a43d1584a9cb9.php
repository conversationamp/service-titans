
<?php $__env->startSection('title', 'Service Titans '); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Service Titans Settings</li>
                    </ol>
                </div>
                <h4 class="page-title">Service Titans Settings</h4>
            </div>
            <!--end page-title-box-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->

    <div class="row">

        <div class="col-md-6">
            <div class="card">
                <h4 class="p-3"> Service Titans Assentials </h4>
                <div class="card-body">
                    <form action="<?php echo e(route('setting.save')); ?>" method="POST" class="card-box"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="name"> Tenant ID </label>
                            <input type="text" class="form-control" name="titan_tenant_id" id="titan_tenant_id"
                                value="<?php echo e(get_values_by_id('titan_tenant_id', login_id())); ?>" placeholder="Enter Tenant Id">
                        </div>
                        <div class="form-group">
                            <label for="name"> App ID </label>
                            <input type="text" class="form-control" name="titan_app_id" id="titan_app_id"
                                value="<?php echo e(get_values_by_id('titan_app_id', login_id())); ?>" placeholder="Enter App id">
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

        <div class="col-md-6">
            <div class="card">
                <h4 class="p-3"> Select Location </h4>
                <div class="card-body">
                    <form action="<?php echo e(route('setting.save')); ?>" method="POST" class="card-box"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="name"> Select Location </label>
                            <input type="hidden" name="its_locations" value="1">
                            <select name="titan_selected_location[]" multiple="multiple" id="titan_selected_location"
                                class="form-control select2">

                                <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $val = [
                                            'name' => $location->name,
                                            'address' => $location->address,
                                        ];
                                        $val = json_encode($val);
                                        
                                        $selected = '';
                                        $loc = get_values_by_id('titan_selected_location', login_id());
                                        if ($loc) {
                                            $loc = json_decode($loc);
                                            foreach ($loc as $key => $value) {
                                                if ($value->name == $location->name) {
                                                    $selected = 'selected';
                                                }
                                            }
                                        }
                                    ?>
                                    <option value="<?php echo e($val); ?>" <?php echo e($selected); ?>>
                                        <?php echo e($location->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

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

        <div class="col-md-6">
            <div class="card">
                <h4 class="p-3">Default Calendar for bookings</h4>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('setting.save')); ?>">
                        <?php echo csrf_field(); ?>
                        <label for="adjustment"> </label>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="calendar"> Select a default calendar for bookings </label>
                                <select name="titan_booking_calendar" id="titan_booking_calendar" class="form-control">
                                    <option value="">Select Calendar</option>
                                    <?php $__currentLoopData = $calendars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $calendar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($calendar->id); ?>"
                                            <?php echo e(get_values_by_id('titan_booking_calendar', login_id()) == $calendar->id ? 'selected' : ''); ?>>
                                            <?php echo e($calendar->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right p-3">
                                <input type="submit" class="btn btn-info" value="Save Settings">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <h4 class="p-3">Default calendar for non job Appointments</h4>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('setting.save')); ?>">
                        <?php echo csrf_field(); ?>
                        <label for="adjustment"> </label>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="calendar"> Select a default calendar for bookings </label>
                                <select name="titan_nonjob_booking_calendar" id="titan_nonjob_booking_calendar"
                                    class="form-control">
                                    <option value="">Select Calendar</option>
                                    <?php $__currentLoopData = $calendars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $calendar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($calendar->id); ?>"
                                            <?php echo e(get_values_by_id('titan_nonjob_booking_calendar', login_id()) == $calendar->id ? 'selected' : ''); ?>>
                                            <?php echo e($calendar->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right p-3">
                                <input type="submit" class="btn btn-info" value="Save Settings">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/settings/titan.blade.php ENDPATH**/ ?>