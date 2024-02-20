  <!-- ============================================================== -->
  <!-- All Jquery -->
  <!-- ============================================================== -->
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <!-- apps -->
  <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
  <script src="{{ asset('dist/js/feather.min.js') }}"></script>
  {{-- Select2 --}}
  <script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>
  <!-- slimscrollbar scrollbar JavaScript -->
  <script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
  <script src="{{ asset('assets/extra-libs/sparkline/sparkline.js') }}"></script>
  <!--Wave Effects -->
  <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
  <script src="{{ asset('dist/js/feather.min.js') }}"></script>
  <script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
  <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
  <!--Custom JavaScript -->
  <script src="{{ asset('dist/js/custom.min.js') }}"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="{{ asset('assets/libs/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
  <!-- Datatables -->
  <script src="{{ asset('assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('dist/js/pages/datatable/datatable-basic.init.js') }}"></script>

  <!-- SweetAlert -->
  @include('sweetalert::alert')

  <!-- Popover JS -->
  <script>
      var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
      var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
          return new bootstrap.Popover(popoverTriggerEl)
      })
  </script>

  <script>
      $(function() {
          //Initialize Select2 Elements
          //   $('.select2').select2()

          //   $("#example1").DataTable();
          //   $('#example2').DataTable({
          //       "paging": true,
          //       "lengthChange": true,
          //       "searching": true,
          //       "ordering": true,
          //       "info": true,
          //       "autoWidth": false,
          //   });
          //   $('#example3').DataTable({
          //       "paging": true,
          //       "lengthChange": true,
          //       "searching": true,
          //       "ordering": true,
          //       "info": true,
          //       "autoWidth": false,
          //   });

          //   $('#example4').DataTable({
          //       "paging": true,
          //       "lengthChange": false,
          //       "searching": false,
          //       "ordering": true,
          //       "info": true,
          //       "autoWidth": false,
          //   });

          //   //Bootstrap Duallistbox
          //   $('.duallistbox').bootstrapDualListbox()
      });
  </script>

  {{-- custom script --}}
  @stack('custom-scripts')
