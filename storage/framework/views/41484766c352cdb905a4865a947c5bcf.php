<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
'editAction',
'deleteRoute',
'deleteMessage' => 'Hapus data ini?',
'editLabel' => 'Edit',
'deleteLabel' => 'Hapus',
]));

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

foreach (array_filter(([
'editAction',
'deleteRoute',
'deleteMessage' => 'Hapus data ini?',
'editLabel' => 'Edit',
'deleteLabel' => 'Hapus',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="d-flex gap-1 justify-content-end">
    <?php if($editAction): ?>
    <button
        type="button"
        class="btn btn-sm btn-white border shadow-sm px-2"
        title="<?php echo e($editLabel); ?>"
        <?php echo e($attributes); ?>>
        <i class="ti ti-edit text-primary"></i>
    </button>
    <?php endif; ?>

    <?php if($deleteRoute): ?>
    <form method="POST" action="<?php echo e($deleteRoute); ?>" class="d-inline" onsubmit="return confirm('<?php echo e($deleteMessage); ?>');">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit" class="btn btn-sm btn-white border shadow-sm px-2" title="<?php echo e($deleteLabel); ?>">
            <i class="ti ti-trash text-danger"></i>
        </button>
    </form>
    <?php endif; ?>
</div><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/components/action-buttons.blade.php ENDPATH**/ ?>