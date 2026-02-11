@props([
'editAction',
'deleteRoute',
'deleteMessage' => 'Hapus data ini?',
'editLabel' => 'Edit',
'deleteLabel' => 'Hapus',
])

<div class="d-flex gap-1 justify-content-end">
    @if($editAction)
    <button
        type="button"
        class="btn btn-sm btn-white border shadow-sm px-2"
        title="{{ $editLabel }}"
        {{ $attributes }}>
        <i class="ti ti-edit text-primary"></i>
    </button>
    @endif

    @if($deleteRoute)
    <form method="POST" action="{{ $deleteRoute }}" class="d-inline" onsubmit="return confirm('{{ $deleteMessage }}');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-white border shadow-sm px-2" title="{{ $deleteLabel }}">
            <i class="ti ti-trash text-danger"></i>
        </button>
    </form>
    @endif
</div>