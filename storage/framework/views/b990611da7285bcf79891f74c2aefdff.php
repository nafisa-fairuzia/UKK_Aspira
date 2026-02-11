<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['icon' => 'ti-inbox', 'message' => 'Tidak ada data', 'colspan' => 6]));

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

foreach (array_filter((['icon' => 'ti-inbox', 'message' => 'Tidak ada data', 'colspan' => 6]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<!-- Placeholder saat data tidak ada -->
<tr>
    <td class="text-center py-4 text-muted" colspan="<?php echo e($colspan); ?>">
        <i class="ti <?php echo e($icon); ?> me-2"></i>
        <?php echo e($message); ?>

    </td>
</tr><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/components/empty-state.blade.php ENDPATH**/ ?>