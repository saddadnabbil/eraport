@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 1:
            $allowedRoutes = ['raportstatuspenilaiankm.*', 'pengelolaannilaikm.*', 'nilairaportkm.*'];

            $checkRouteAssesmentStatus = request()->routeIs('raportstatuspenilaiankm.*');
            $dynamicRouteAssesmentStatus = route('raportstatuspenilaiankm.index');

            $checkRouteHasilPengelolaan = request()->routeIs('pengelolaannilaikm.*');
            $dynamicRouteHasilPengelolaan = route('pengelolaannilaikm.index');
            
            $checkRouteSemesterReportValue = request()->routeIs('nilairaportkm.*');
            $dynamicRouteSemesterReportValue = route('nilairaportkm.index');
            break;
        case 2:
            $allowedRoutes = ['kirimnilaiakhirkm.*', 'kirimnilaiakhirkm.*', 'nilairaportkmwalas.*'];
            
            $checkRouteAssesmentStatus = request()->routeIs('statusnilaiguru.*');
            $dynamicRouteAssesmentStatus = route('statusnilaiguru.index');

            $checkRouteHasilPengelolaan = request()->routeIs('hasilnilai.*');
            $dynamicRouteHasilPengelolaan = route('hasilnilai.index');

            $checkRouteSemesterReportValue = request()->routeIs('nilairaportkmwalas.*');
            $dynamicRouteSemesterReportValue = route('nilairaportkmwalas.index');
            break;
    }
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
        ],
        [
            'name' => 'Pengelolaan Nilai',
            'route' => $dynamicRouteHasilPengelolaan,
            'isActive' => $checkRouteHasilPengelolaan,
        ],
        [
            'name' => 'Semester Report Value',
            'route' => $dynamicRouteSemesterReportValue,
            'isActive' => $checkRouteSemesterReportValue,
        ],
    ],
])