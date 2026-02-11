<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['user', 'size' => '35']));

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

foreach (array_filter((['user', 'size' => '35']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php

$initials = substr($user->nama ?? 'U', 0, 1);
$profilePic = $user->profile_pic ?? null;
$sizeStyle = "width: {$size}px; height: {$size}px; flex-shrink: 0;";
$imgStyle = "{$sizeStyle} object-fit: cover; border: 1px solid #ddd;";
?>

<?php if($profilePic): ?>
<img
    src="<?php echo e(asset('storage/' . $profilePic)); ?>"
    class="rounded-circle border shadow-sm"
    alt="<?php echo e($user->nama ?? 'Avatar'); ?>"
    style="<?php echo e($imgStyle); ?>">
<?php else: ?>
<div class="avatar-sm bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center" style="<?php echo e($sizeStyle); ?>">
    <span class="text-primary fw-bold small"><?php echo e($initials); ?></span>
</div>
<?php endif; ?><?php /**PATH C:\laragon\www\UKK_Aspira\resources\views/components/avatar.blade.php ENDPATH**/ ?>