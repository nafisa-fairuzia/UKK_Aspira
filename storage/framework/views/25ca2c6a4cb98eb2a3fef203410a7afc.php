<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['type' => 'success', 'icon' => null, 'message' => null]));

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

foreach (array_filter((['type' => 'success', 'icon' => null, 'message' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php

$alertConfig = [
'success' => ['class' => 'alert-success', 'icon' => 'ti-check', 'key' => 'success'],
'error' => ['class' => 'alert-danger', 'icon' => 'ti-alert-circle', 'key' => 'error'],
'warning' => ['class' => 'alert-warning', 'icon' => 'ti-alert-triangle', 'key' => 'warning'],
'info' => ['class' => 'alert-info', 'icon' => 'ti-info-circle', 'key' => 'info'],
];

$config = $alertConfig[$type] ?? $alertConfig['success'];
$displayIcon = $icon ?? $config['icon'];
$displayMessage = $message ?? session($config['key']);
?>

<?php if($displayMessage): ?>
<div class="alert <?php echo e($config['class']); ?> border-0 shadow-sm rounded-3 mb-4 py-2 small" role="alert">
    <i class="ti <?php echo e($displayIcon); ?> me-2"></i>
    <?php echo e($displayMessage); ?>

</div>
<?php endif; ?><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/components/alert.blade.php ENDPATH**/ ?>