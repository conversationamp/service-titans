
<?php $__env->startSection('title', 'Contacts logs'); ?>
<?php $__env->startSection('content'); ?>
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item ">Dashboard</li>
                        <li class="breadcrumb-item active">Contacts Logs</li>
                    </ol>
                </div>
                <h4 class="page-title"> Contacts </h4>
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
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address </th>
                                </tr>
                                <!--end tr-->
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $contact = json_decode($contact->go_response ?? '') ?>

                                    <tr>
                                        <td><?php echo e($contact->firstName ?? ''); ?> <?php echo e($contact->lastName ??''); ?></td>
                                        <td><?php echo e($contact->email??""); ?></td>
                                        <td><?php echo e($contact->phone??""); ?></td>
                                        <td><?php echo e($contact->address->street??""); ?> <?php echo e($contact->address->unit ??""); ?>

                                            <?php echo e($contact->address->city??""); ?> <?php echo e($contact->address->state??""); ?>

                                            <?php echo e($contact->address->zip??""); ?> <?php echo e($contact->address->country??""); ?></td>
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/logs/contact.blade.php ENDPATH**/ ?>