<?php
$child = true;
if (empty($title)) {
    $child = false;
    $title = $parent;
}
if(!isset($subchild))
{
    $subchild='';
}
?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item <?php if(!$child): ?> active <?php endif; ?>">
                        <?php if($child): ?>
                            <a href="<?php echo e(route($route . '.list')); ?>"><?php echo e($parent); ?></a>
                            
                        <?php else: ?>
                            <?php echo e($parent); ?>

                        <?php endif; ?>
                    </li>
                    <?php if(!empty($subchild)): ?>
                              <li class="breadcrumb-item "> <a href="<?php echo e(route($route . '.view',$id)); ?>"><?php echo e($subchild); ?></a></li>
                            <?php endif; ?>
                    <?php if($child): ?>
                        <li class="breadcrumb-item active"><?php echo e($title); ?></li>
                    <?php endif; ?>
                </ol>
            </div>
            <h4 class="page-title"><?php echo e($title); ?></h4>
        </div>
        <!--end page-title-box-->
    </div>
    <!--end col-->
</div>
<?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/components/breadcrumb.blade.php ENDPATH**/ ?>