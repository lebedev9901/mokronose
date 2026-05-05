<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['value']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['value']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<label <?php echo e($attributes->merge(['class' => 'block font-medium text-sm text-gray-700'])); ?>>
    <?php echo e($value ?? $slot); ?>

<<<<<<<< HEAD:storage/framework/views/5a39a70a2c9c39f544cda7ee54fdcc82.php
/>
<?php /**PATH C:\Users\AdminPC\Herd\mokronose\vendor\filament\support\resources\views/components/avatar.blade.php ENDPATH**/ ?>
========
</label>
<?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/components/input-label.blade.php ENDPATH**/ ?>
>>>>>>>> 6c8703de2f5adfd1e5348e4946eaaf01427e01e0:storage/framework/views/c63413c1b6a6ba1e3d14158a7aa88c59.php
