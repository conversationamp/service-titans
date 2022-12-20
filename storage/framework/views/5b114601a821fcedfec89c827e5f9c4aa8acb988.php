<?php
    if(empty($save)){
        $save='Save';
    }
?>
<div class="form-group">
    <a href="<?php echo e(route($route.'.list')); ?>" class="btn btn-danger btn-sm text-light px-4 mt-3 float-right mb-0 ml-2">Cancel</a>
    <button type="submit" name="save_add" class="btn btn-secondary ml-3 btn-sm text-light px-4 mt-3 float-right mb-0"><?php echo e($save); ?> & Back</button>
    <button type="submit" name="save" class="btn btn-primary btn-sm text-light px-4 mt-3 float-right mb-0"><?php echo e($save); ?></button>
</div>
<?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/components/form/savebutton.blade.php ENDPATH**/ ?>