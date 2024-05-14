@php
    $userRole = Auth::user()->getRoleNames()->first();

    $allowedRoutes = ['km.cp.*', 'km.rencanaformatif.*', 'km.rencanasumatif.*'];

    $checkRouteCP = request()->routeIs('km.cp.*');
    $dynamicRouteCP = route('km.cp.index');

    $checkRouteFormatif = request()->routeIs('km.rencanaformatif.*');
    $dynamicRouteFormatif = route('km.rencanaformatif.index');

    $checkRouteSumatif = request()->routeIs('km.rencanasumatif.*');
    $dynamicRouteSumatif = route('km.rencanasumatif.index');
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs($allowedRoutes),
    'hasArrow' => true,
    'icon' => 'file-text',
    'itemName' => 'Rencana Penilaian',
    'route' => 'javascript:void(0)',
    'subItems' => [
        [
            'name' => 'Capaian Pembelajaran',
            'route' => $dynamicRouteCP,
            'isActive' => $checkRouteCP,
            'childHasArrow' => false,
        ],
        [
            'name' => 'Rencana Formatif',
            'route' => $dynamicRouteFormatif,
            'isActive' => $checkRouteFormatif,
            'childHasArrow' => false,
        ],
        [
            'name' => 'Rencana Sumatif',
            'route' => $dynamicRouteSumatif,
            'isActive' => $checkRouteSumatif,
            'childHasArrow' => false,
        ],
    ],
])
