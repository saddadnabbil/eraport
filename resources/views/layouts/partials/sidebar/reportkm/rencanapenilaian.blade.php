@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $allowedRoutes = ['km.cp.*', 'km.rencanaformatif.*', 'km.rencanasumatif.*'];

            $checkRouteCP = request()->routeIs('km.cp.*');
            $dynamicRouteCP = route('km.cp.index');

            $checkRouteFormatif = request()->routeIs('km.rencanaformatif.*');
            $dynamicRouteFormatif = route('km.rencanaformatif.index');

            $checkRouteSumatif = request()->routeIs('km.rencanasumatif.*');
            $dynamicRouteSumatif = route('km.rencanasumatif.index');
            break;
        case 'Teacher':
            $allowedRoutes = ['guru.km.cp.*', 'guru.km.rencanaformatif.*', 'guru.km.rencanasumatif.*'];

            $checkRouteCP = request()->routeIs('guru.km.cp.*');
            $dynamicRouteCP = route('guru.km.cp.index');

            $checkRouteFormatif = request()->routeIs('guru.km.rencanaformatif.*');
            $dynamicRouteFormatif = route('guru.km.rencanaformatif.index');

            $checkRouteSumatif = request()->routeIs('guru.km.rencanasumatif.*');
            $dynamicRouteSumatif = route('guru.km.rencanasumatif.index');

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
