@php
    $userRole = Auth::user()->getRoleNames()->first();

    $allowedRoutes = ['km.raportpts.*', 'km.raportsemester.*'];

    $checkRouteMidSemesterReport = request()->routeIs('km.raportpts.*');
    $dynamicRouteMidSemesterReport = route('km.raportpts.index');

    $checkRouteSemesterReport = request()->routeIs('km.raportsemester.*');
    $dynamicRouteSemesterReport = route('km.raportsemester.index');

    $checkRouteP5Report = request()->routeIs('p5.raport.*');
    $dynamicRouteP5Report = route('p5.raport.index');

@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs($allowedRoutes),
    'hasArrow' => true,
    'icon' => 'file',
    'itemName' => 'Print Report',
    'route' => 'javascript:void(0)',
    'subItems' => [
        [
            'name' => 'Mid-Semester Report',
            'route' => $dynamicRouteMidSemesterReport,
            'isActive' => $checkRouteMidSemesterReport,
            'childHasArrow' => false,
        ],
        [
            'name' => 'Semester Report',
            'route' => $dynamicRouteSemesterReport,
            'isActive' => $checkRouteSemesterReport,
            'childHasArrow' => false,
        ],
        [
            'name' => 'P5BK Report',
            'route' => $dynamicRouteP5Report,
            'isActive' => $checkRouteP5Report,
            'childHasArrow' => false,
        ],
    ],
])
