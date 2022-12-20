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

                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <?php if(auth()->user()->role == admin_role()): ?>
                                        <th>Location</th>
                    
                                        <th class="text-right">Action</th>
                                    <?php endif; ?>
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
                    data: 'name',
                    name: 'name'
                }, {
                    data: 'email',
                    name: 'email'
                }, {
                    data: 'status',
                    name: 'status',
                    searchable: false
                }
                <?php if(auth()->user()->role == admin_role()): ?>
                    , {
                        data: 'location',
                        name: 'location'
                    }, {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        class: 'text-right'
                    }
                <?php endif; ?>
            ]
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/user/list.blade.php ENDPATH**/ ?>