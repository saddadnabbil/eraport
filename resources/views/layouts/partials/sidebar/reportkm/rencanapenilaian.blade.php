@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 1:
            $allowedRoutes = ['cp.*', 'rencanaformatif.*', 'rencanasumatif.*'];

            $checkRouteCP = request()->routeIs('cp.*');
            $dynamicRouteCP = route('cp.index');

            $checkRouteFormatif = request()->routeIs('rencanaformatif.*');
            $dynamicRouteFormatif = route('rencanaformatif.index');

            $checkRouteSumatif = request()->routeIs('rencanasumatif.*');
            $dynamicRouteSumatif = route('rencanasumatif.index');
            break;
        case 2:
            $allowedRoutes = ['guru.cp.*', 'guru.rencanaformatif.*', 'guru.rencanasumatif.*'];

            $checkRouteCP = request()->routeIs('guru.cp.*');
            $dynamicRouteCP = route('guru.cp.index');

            $checkRouteFormatif = request()->routeIs('guru.rencanaformatif.*');
            $dynamicRouteFormatif = route('guru.rencanaformatif.index');

            $checkRouteSumatif = request()->routeIs('guru.rencanasumatif.*');
            $dynamicRouteSumatif = route('guru.rencanasumatif.index');
            
            break;
        default:
    }
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
        ],
        [
            'name' => 'Rencana Formatif',
            'route' => $dynamicRouteFormatif,
            'isActive' => $checkRouteFormatif,
        ],
        [
            'name' => 'Rencana Sumatif',
            'route' => $dynamicRouteSumatif,
            'isActive' => $checkRouteSumatif,
        ],
    ],
])