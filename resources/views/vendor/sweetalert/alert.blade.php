<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

@if (config('sweetalert.alwaysLoadJS') === true && config('sweetalert.neverLoadJS') === false)
    <script src="{{ $cdn ?? asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
@endif
@if (Session::has('alert.config'))
    @if (config('sweetalert.animation.enable'))
        <link rel="stylesheet" href="{{ config('sweetalert.animatecss') }}">
    @endif
    @if (config('sweetalert.alwaysLoadJS') === false && config('sweetalert.neverLoadJS') === false)
        <script src="{{ $cdn ?? asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    @endif
    <script>
        Swal.fire({!! Session::pull('alert.config') !!});
    </script>
@endif
<!-- sweetalert confirm delete -->
<script>
    function confirmDeleteAndSubmit(title, id) {
        Swal.fire({
            title: 'Delete ' + title + ' ?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'Cancel',
            timer: 5000, // 5000 milliseconds (5 seconds) delay
            timerProgressBar: true,
            allowOutsideClick: false // Prevent closing the modal by clicking outside
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms, submit the form
                document.getElementById('deleteForm' + id).submit();
            }
        });
    }

    function confirmActiveAndSubmit(title, id) {
        Swal.fire({
            title: 'Apakah benar ingin mengaktifkan ' + title + ' ?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'Cancel',
            timer: 5000, // 5000 milliseconds (5 seconds) delay
            timerProgressBar: true,
            allowOutsideClick: false // Prevent closing the modal by clicking outside
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms, submit the form
                document.getElementById('deleteForm' + id).submit();
            }
        });
    }

    function confirmAction(id, action, title, text) {
        Swal.fire({
            title: title,
            text: text,
            icon: action === 'delete' ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonColor: action === 'delete' ? '#d33' : '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: action === 'delete' ? 'Yes, Delete!' : 'Yes, ' + action.charAt(0).toUpperCase() +
                action.slice(1) + '!'
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
