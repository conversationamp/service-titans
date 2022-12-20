<?php

if (empty($column)) {
    $column = '12';
}

if (empty($default)) {
    $default = '';
}

$required = !empty($required);

if (empty($type)) {
    $type = 'text';
}
if (empty($action)) {
    $action='';
}
if (empty($id)) {
    $id=$name;
}

if (empty($class)) {
    $class='';
}
if (empty($label_class)) {
    $label_class='';
}

?>
<div class="col-md-<?php echo e($column); ?>">
    <label for="<?php echo e($id); ?>" class="<?php echo e($label_class); ?>"><?php echo e($title); ?> <?php echo e($required ? '*' : ''); ?></label>
    <input type="<?php echo e($type); ?>" placeholder="<?php echo e($title); ?>" class="form-control <?php echo e($class); ?> <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        name="<?php echo e($name); ?>" value="<?php echo e(old($name, $default)); ?>" id="<?php echo e($id); ?>" autocomplete="off"
        <?php echo e($required ? 'required' : ''); ?> <?php echo e($action); ?>>
    <?php $__errorArgs = [$name];
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
<?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/components/form/input.blade.php ENDPATH**/ ?>