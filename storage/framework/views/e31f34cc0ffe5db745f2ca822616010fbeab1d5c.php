<?php $__env->startSection('title', $parent); ?>

<?php $__env->startSection('content'); ?>
    <!-- Page-Title -->
    <?php echo $__env->make('admin.components.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row">
        <div class="col-md-12 text-right">
            <a href="<?php echo e(route($route . '.add')); ?>" class="btn btn-gradient-primary px-4 mt-0 mb-3"><i
                    class="mdi mdi-plus-circle-outline mr-2"></i>Add New</a>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead class="thead-light">
                                <tr>
                                    
                                    <th>Pipeline</th>
                                    <th>Pipeline Stage</th>
                                    <th>Calendar</th>
                                    <th>Calendar</th>
                                    <th>Oppurtunity Status</th>
                                    <th>Appointment Status</th>
                                    
                                    <th>Location </th>
                                    <th>Business Unit d</th>
                                    <th>Compaign </th>
                                    <th>Priority</th>
                                    <th>Job Type</th>
                                    <th>Slot</th>
                                    <th>Position</th>
                                    <th>Default</th>
                                    <th> Action </th>
                                </tr>
                                <!--end tr-->
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script>
        // Datatable
        let table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?php echo e(route($route . '.list')); ?>",
            },

            columns: [{
                    data: 'pipeline_name',
                    name: 'pipeline_name'
                },
                {
                    data: 'pipeline_stage_name',
                    name: 'pipeline_stage_name'
                },
                {
                    data: 'calendar_name',
                    name: 'calendar_name'
                },
                {
                    data: 'calendar_id',
                    name: 'calendar_id'
                },
                {
                    data: 'oppurtunity_status',
                    name: 'oppurtunity_status'
                },
                {
                    data: 'appointment_status',
                    name: 'appointment_status'
                },
                {
                    data: 'titan_location_name',
                    name: 'titan_location_name'
                },
                {
                    data: 'business_unit_name',
                    name: 'business_unit_name'
                },
                {
                    data: 'campaign_name',
                    name: 'campaign_name'
                },
                {
                    data: 'priority',
                    name: 'priority'
                },
                {
                    data: 'job_type_name',
                    name: 'job_type_name'
                },
                {
                    data: 'slot',
                    name: 'slot'
                },
                {
                    data: 'position',
                    name: 'position'
                },
                {
                    data: 'is_default',
                    name: 'is_default'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            order: [
                [3, 'asc']
            ],
            // rowGroup: {
            //     startRender: function ( rows, group ) {
            //      return group +' Please select default from below rows';
            //  },
            //     dataSrc: ['calendar_id']
            //    },
            columnDefs: [{
                targets: [3],
                visible: false
            }]

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/sync-settings/list.blade.php ENDPATH**/ ?>