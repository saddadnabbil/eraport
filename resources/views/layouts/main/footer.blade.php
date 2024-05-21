  <!-- ============================================================== -->
  <!-- All Jquery -->
  <!-- ============================================================== -->
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <!-- apps -->
  <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
  <script src="{{ asset('dist/js/feather.min.js') }}"></script>
  {{-- Select2 --}}
  {{-- <script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

  <script>
      $(document).ready(function() {
          // Select2 for elements inside any modal
          $(".modal").on('shown.bs.modal', function() {
              $(this).find('.select2').select2({
                  dropdownParent: $(this).find('.modal-content'),
                  theme: "bootstrap-5",
                  width: '100%',
                  placeholder: $(this).data('placeholder'),
              });
          });

          // Initialize Select2 for existing modals on page load
          $(".modal:visible").each(function() {
              $(this).find('.select2').select2({
                  dropdownParent: $(this).find('.modal-content'),
                  width: '100%'
              });
          });

          // Select2 for elements outside any modal
          $('.select2:not(.modal .select2)').select2({
              theme: "bootstrap-5",
              width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                  'style',
              placeholder: $(this).data('placeholder'),
          });

          $('.duallistbox').bootstrapDualListbox()
      });
  </script>

  {{-- custom script --}}
  @stack('custom-scripts')
