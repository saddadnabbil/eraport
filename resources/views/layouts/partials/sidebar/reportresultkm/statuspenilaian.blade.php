@php
    $userRole = Auth::user()->getRoleNames()->first();

    $allowedRoutes = ['raportstatuskm.penilaian.*', 'pengelolaannilaikm.*', 'nilairaportkm.*'];

    $checkRouteAssesmentStatus = request()->routeIs('raportstatuskm.penilaian.*');
    $dynamicRouteAssesmentStatus = route('raportstatuskm.penilaian.index');

    $checkRouteHasilPengelolaan = request()->routeIs('pengelolaannilaikm.*');
    $dynamicRouteHasilPengelolaan = route('pengelolaannilaikm.index');

    $checkRouteSemesterReportValue = request()->routeIs('nilairaportkm.*');
    $dynamicRouteSemesterReportValue = route('nilairaportkm.index');
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs($allowedRoutes),
    'hasArrow' => true,
    'icon' => 'home',
    'itemName' => 'Rating Result',
    'route' => 'javascript:void(0)',
    'subItems' => [
        [
            'name' => 'Assessment Status',
            'route' => $dynamicRouteAssesmentStatus,
            'isActive' => $checkRouteAssesmentStatus,
            'childHasArrow' => false,
        ],
        [
            'name' => 'Pengelolaan Nilai',
            'route' => $dynamicRouteHasilPengelolaan,
            'isActive' => $checkRouteHasilPengelolaan,
            'childHasArrow' => false,
        ],
        [
            'name' => 'Semester Report Value',
            'route' => $dynamicRouteSemesterReportValue,
            'isActive' => $checkRouteSemesterReportValue,
            'childHasArrow' => false,
        ],
    ],
])
