@props(['icon' => 'ti-inbox', 'message' => 'Tidak ada data', 'colspan' => 6])

<tr>
    <td class="text-center py-4 text-muted" colspan="{{ $colspan }}">
        <i class="ti {{ $icon }} me-2"></i>
        {{ $message }}
    </td>
</tr>