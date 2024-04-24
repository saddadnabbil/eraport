@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $allowedRoutes = ['cp.*', 'rencanaformatif.*', 'rencanasumatif.*'];

            $checkRouteCP = request()->routeIs('cp.*');
            $dynamicRouteCP = route('cp.index');

            $checkRouteFormatif = request()->routeIs('rencanaformatif.*');
            $dynamicRouteFormatif = route('rencanaformatif.index');

            $checkRouteSumatif = request()->routeIs('rencanasumatif.*');
            $dynamicRouteSumatif = route('rencanasumatif.index');
            break;
        case 'Teacher':
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
