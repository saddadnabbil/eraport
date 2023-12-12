@if (config('sweetalert.alwaysLoadJS') === true && config('sweetalert.neverLoadJS') === false )
    <script src="{{ $cdn ?? asset('vendor/sweetalert/sweetalert.all.js')  }}"></script>
@endif
@if (Session::has('alert.config'))
    @if(config('sweetalert.animation.enable'))
        <link rel="stylesheet" href="{{ config('sweetalert.animatecss') }}">
    @endif
    @if (config('sweetalert.alwaysLoadJS') === false && config('sweetalert.neverLoadJS') === false)
        <script src="{{ $cdn ?? asset('vendor/sweetalert/sweetalert.all.js')  }}"></script>
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
</script>
