@props(['type' => 'success', 'icon' => null, 'message' => null])

@php

$alertConfig = [
'success' => ['class' => 'alert-success', 'icon' => 'ti-check', 'key' => 'success'],
'error' => ['class' => 'alert-danger', 'icon' => 'ti-alert-circle', 'key' => 'error'],
'warning' => ['class' => 'alert-warning', 'icon' => 'ti-alert-triangle', 'key' => 'warning'],
'info' => ['class' => 'alert-info', 'icon' => 'ti-info-circle', 'key' => 'info'],
];

$config = $alertConfig[$type] ?? $alertConfig['success'];
$displayIcon = $icon ?? $config['icon'];
$displayMessage = $message ?? session($config['key']);
@endphp

@if($displayMessage)
<div class="alert {{ $config['class'] }} border-0 shadow-sm rounded-3 mb-4 py-2 small" role="alert">
    <i class="ti {{ $displayIcon }} me-2"></i>
    {{ $displayMessage }}
</div>
@endif