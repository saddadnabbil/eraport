  <aside class="left-sidebar" data-sidebarbg="skin6">
      <!-- Sidebar scroll-->
      <div class="scroll-sidebar" data-sidebarbg="skin6">
          <!-- Sidebar navigation-->
          <nav class="sidebar-nav">
              <ul id="sidebarnav">
                  <li class="sidebar-item">
                      <a class="sidebar-link sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false"><i
                              data-feather="home" class="feather-icon"></i><span class="hide-menu"> Dashboard
                          </span></a>
                  </li>
                  @include('layouts.partials.sidebar.admin.user')
                  @include('layouts.partials.sidebar.admin.karyawan')

                  @include('layouts.partials.sidebar.admin.pengumuman')
                  @include('layouts.partials.sidebar.admin.masterdata')

                  <li class="list-divider"></li>

                  <li class="nav-small-cap">
                      <span class="hide-menu">REPORT KM</span>
                  </li>
                  @include('layouts.partials.sidebar.reportkm.inputdata')
                  @include('layouts.partials.sidebar.reportkm.rencanapenilaian')
                  @include('layouts.partials.sidebar.reportkm.penilaian')
                  @include('layouts.partials.sidebar.reportkm.nilaiekstra')
                  @include('layouts.partials.sidebar.reportkm.nilaiakhir')
                  @include('layouts.partials.sidebar.reportkm.prosesdeskripsi')

                  <li class="list-divider"></li>
                  <li class="nav-small-cap">
                      <span class="hide-menu">REPORT RESULTS KM</span>
                  </li>
                  @include('layouts.partials.sidebar.reportresultkm.statuspenilaian')
                  @include('layouts.partials.sidebar.reportresultkm.rekapkehadiran')
                  @include('layouts.partials.sidebar.reportresultkm.leger')
                  @include('layouts.partials.sidebar.reportresultkm.printreport')


                  <li class="list-divider"></li>
                  <li class="nav-small-cap">
                      <span class="hide-menu">AUTHTENTICATION</span>
                  </li>
                  <li class="sidebar-item">
                      <form class="sidebar-link sidebar-link" id="logout-form" action="{{ route('logout') }}"
                          method="POST" style="display: inline;">
                          @csrf
                          <button type="button" onclick="confirmLogout()"
                              class="text-decoration-none border-0 bg-transparent btn-link text-danger"> <i
                                  data-feather="log-out" class="feather-icon text-danger"></i>Logout</button>
                      </form>
                  </li>
          </nav>
          <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
  </aside>
