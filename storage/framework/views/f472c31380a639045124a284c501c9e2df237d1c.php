<?php
    $oppurtunity_status = [
        'open' => 'Open',
        'won' => 'Won',
        'lost' => 'Lost',
        'abondoned' => 'Abondoned',
    ];
    
    $appointment_status = [
        'confirmed' => 'Confirmed',
        'new' => 'New',
        'showed' => 'Showed',
        'noshow' => 'No Show',
        'booked' => 'Booked',
        'cancelled' => 'Cancelled',
    ];
    
    $priorities = [
        'high' => 'High',
        'normal' => 'Normal',
        'low' => 'Low',
        'urgent' => 'Urgent',
    ];
    /*
            
        
            Appointment Status Titan : Scheduled , Dispatched , Working , Hold , Done , Canceled
        
            
            */
?>

<div class="col-md-4">
    <div class="form-group">
        <label for="calendars_data"> Select Calendar </label>
        <select name="calendar_id[]" id="calendar_id" data-selected="<?php echo e(check_field($data, 'calendar_id')); ?>"
            class="auto-select form-control">
            <option value="">Select Calendar</option>
            <?php $__currentLoopData = $calendars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $calendar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($calendar->id); ?>"><?php echo e($calendar->name); ?> </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <input type="hidden" name="calendar_name[]" id="calendar_name" value="" />
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Pipeline </label>
        <select name="pipeline_id[]" data-selected="<?php echo e(check_field($data, 'pipeline_id')); ?>" id="pipeline_id"
            class="auto-select form-control">
            <option value=""> Please Select Pipeline </option>
            <?php $__currentLoopData = $pipelines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pipeline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($pipeline->id); ?>"> <?php echo e($pipeline->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <input type="hidden" name="pipeline_name[]" id="pipeline_name" value="" />
    </div>
</div>

<div class="col-md-4">
    <div class="form-group ">
        <div class="pipeline_stages">

        </div>
        <input type="hidden" name="pipeline_stage_name[]" id="pipeline_stage_name" value="" />
    </div>

</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Opportunity Status </label>
        <select name="oppurtunity_status[]" id="oppurtunity_status"
            data-selected="<?php echo e(check_field($data, 'oppurtunity_status')); ?>" class="form-control auto-select">
            <?php $__currentLoopData = $oppurtunity_status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key); ?>"> <?php echo e($status); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <input type="hidden" name="oppurtunity_status_name[]" id="oppurtunity_status_name" value="" />
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Appointment Status </label>

        <select name="appointment_status[]" id="appointment_status"
            data-selected="<?php echo e(check_field($data, 'appointment_status')); ?>" class="auto-select form-control">
            <option value=""> Please Select Appointment Status </option>
            <?php $__currentLoopData = $appointment_status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key); ?>"> <?php echo e($status); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <input type="hidden" name="appointment_status_name[]" value="">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Location </label>
        <select name="location[]" id="location" data-selected="<?php echo e(check_field($data, 'titan_location_id')); ?>"
            class="auto-select form-control">
            <option value=""> Please Select Location </option>
            <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($location->id); ?>"> <?php echo e($location->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <input type="hidden" name="location_name[]" value="">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Business Unit </label>
        <select name="business_unit[]" id="business_unit" data-selected="<?php echo e(check_field($data, 'business_unit')); ?>"
            class="auto-select form-control">
            <option value="">Pleass select Business Unit</option>
            <?php $__currentLoopData = $business_units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $business_unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($business_unit->id); ?>"> <?php echo e($business_unit->officialName); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <input type="hidden" name="business_unit_name[]" value="">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Campaign </label>
        <select name="campaign[]" id="campaign" data-selected="<?php echo e(check_field($data, 'campaign')); ?>"
            class="auto-select form-control">
            <option value=""> Please Select Campaign </option>
            <?php $__currentLoopData = $compaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($campaign->id); ?>"> <?php echo e($campaign->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <input type="hidden" name="campaign_name[]" value="">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Priority </label>
        <select name="priority[]" id="priority" data-selected="<?php echo e(check_field($data, 'priority')); ?>"
            class="auto-select form-control">
            <option value=""> Please Select Priority </option>
            <?php $__currentLoopData = $priorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key); ?>"> <?php echo e($priority); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Job Type </label>
        <select name="job_type[]" id="job_type" data-selected="<?php echo e(check_field($data, 'job_type')); ?>"
            class="auto-select form-control">
            <option value=""> Please Select Job Type </option>
            <?php $__currentLoopData = $job_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $job_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($job_type->id); ?>"> <?php echo e($job_type->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <input type="hidden" name="job_type_name[]" class="ht" value="">
    </div>
</div>



<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Invoice </label>
        <select name="invoice_id[]" id="invoice_id" data-selected="<?php echo e(check_field($data, 'titan_invoice_id')); ?>"
            class="auto-select form-control">
            <option value=""> Please Select Job Type </option>
            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($invoice->id); ?>"> For <?php echo e($invoice->id .'('.$invoice->customer->name .')'); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for=""> Select Technician </label>
        <select name="technician_id[0][]" id="technician_id"
            data-selected="<?php echo e(array_string(check_field($data, 'technician_id'), true)); ?>"
            class="auto-select form-control select2 technician_id" multiple>
            <option value=""> Please Select Technician </option>
            <?php $__currentLoopData = $technicians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $technician): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($technician->id); ?>"> <?php echo e($technician->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <input type="hidden" name="technician_name[]" value="">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="a_time">Apponitment Duration <small>(add minutes in current time)</small></label>
        <input type="number" class="form-control" name="slot[]" value="<?php echo e(check_field($data, 'slot')); ?>"
            placeholder="please  enter number of minutes">
    </div>
</div>
<?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/sync-settings/sync-response.blade.php ENDPATH**/ ?>