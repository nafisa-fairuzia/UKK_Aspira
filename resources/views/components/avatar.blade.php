@props(['user', 'size' => '35'])

@php

$initials = substr($user->nama ?? 'U', 0, 1);
$profilePic = $user->profile_pic ?? null;
$sizeStyle = "width: {$size}px; height: {$size}px; flex-shrink: 0;";
$imgStyle = "{$sizeStyle} object-fit: cover; border: 1px solid #ddd;";
@endphp

@if($profilePic)
<img
    src="{{ asset('storage/' . $profilePic) }}"
    class="rounded-circle border shadow-sm"
    alt="{{ $user->nama ?? 'Avatar' }}"
    style="{{ $imgStyle }}">
@else
<div class="avatar-sm bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center" style="{{ $sizeStyle }}">
    <span class="text-primary fw-bold small">{{ $initials }}</span>
</div>
@endif