
<?php $__env->startSection('title', 'Opportunity logs'); ?>
<?php $__env->startSection('content'); ?>
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item ">Dashboard</li>
                        <li class="breadcrumb-item active">Opportunity Logs</li>
                    </ol>
                </div>
                <h4 class="page-title"> Opportunity </h4>
            </div>
            <!--end page-title-box-->
        </div>
        <!--end col-->
    </div>

    

    

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Contact Name</th>
                                    <th> Opportunity Name </th>
                                    <th> Opportunity status </th>
                                    <th> Monetary Value </th>
                                </tr>
                                <!--end tr-->
                            </thead>
                            <tbody>
                                
                                <?php $__currentLoopData = $opportunities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opportunity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $opportunity = json_decode($opportunity->go_response ?? '');
                                    ?>

                                    <tr>
                                        
                                        <td><?php echo e(getContactName($opportunity->contact_id)); ?></td>
                                        <td><?php echo e($opportunity->name); ?></td>
                                        <td><?php echo e($opportunity->oppurtunity_status); ?></td>
                                        <td><?php echo e($opportunity->monetary_value); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    $(document).ready(function() {
        $('#datatable').DataTable();
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/logs/opportunity.blade.php ENDPATH**/ ?>