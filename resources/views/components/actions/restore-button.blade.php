<!-- resources/views/components/restore-button.blade.php -->
<div data-bs-toggle="tooltip" data-bs-original-title="Restore">
    <form id="restoreForm{{ $id }}" method="POST" action="{{ $route }}">
        @csrf
        @method('PATCH')
        <button type="button" class="btn btn-primary btn-sm mt-1"
            onclick="confirmAction('{{ $id }}', 'restore', 'Restore', 'Are you sure you want to restore this data?')">
            <i class="fas fa-undo"></i>
        </button>
    </form>
</div>
