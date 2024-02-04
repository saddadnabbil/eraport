<!-- resources/views/components/sweet-alert-script.blade.php -->

<script>
    function confirmAction(id, action, title, text) {
        Swal.fire({
            title: title,
            text: text,
            icon: action === 'delete' ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonColor: action === 'delete' ? '#d33' : '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: action === 'delete' ? 'Yes, Delete!' : 'Yes, ' + action.charAt(0).toUpperCase() + action.slice(1) + '!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if confirmed
                document.getElementById(action + 'Form' + id).submit();
            }
        });
    }

    function confirmLogout() {
        Swal.fire({
            title: 'Konfirmasi Logout',
            text: 'Apakah Anda yakin ingin keluar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Logout!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if confirmed
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>