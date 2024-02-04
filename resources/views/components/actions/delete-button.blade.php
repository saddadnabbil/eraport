<!-- resources/views/components/delete-edit-button.blade.php -->

<form action="{{ $route }}" method="POST" id="deleteForm{{ $id }}">
    @csrf
    @method('DELETE')
    <div class="d-flex gap-2">
        @if ($withEdit)
            <div data-bs-toggle="tooltip" data-bs-original-title="Edit">
                <button type="button" class="btn btn-warning btn-sm mt-1" data-bs-toggle="modal"
                    data-bs-target="#modal-edit{{ $id }}">
                    <i class="fas fa-pencil-alt"></i>
                </button>
            </div>
        @endif
        @if ($withShow)
            <div data-bs-toggle="tooltip" data-bs-original-title="Show">
                <a href="{{ $showRoute }}" class="btn btn-info btn-sm mt-1">
                    <i class="fas fa-eye"></i>
                </a>
            </div>
        @endif
        <div data-bs-toggle="tooltip" data-bs-original-title="Delete">
            <button type="button" class="btn btn-danger btn-sm mt-1"
            onclick="confirmAction('{{ $id }}', 'delete', 'Delete {{ $isPermanent ? 'Permanent' : 'Data' }}' + '?', '{{ $isPermanent ? 'Are you sure you want to delete this data permanently?' : 'The data will be deleted' }}' )">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    </div>
</form>
