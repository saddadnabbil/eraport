@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $allowedRoutes = ['km.kirimnilaiakhir.*', 'km.nilaiterkirim.*'];

            $checkRouteKirim = request()->routeIs('km.kirimnilaiakhir.*');
            $dynamicRouteKirim = route('km.kirimnilaiakhir.index');

            $checkRouteLihat = request()->routeIs('km.nilaiterkirim.*');
            $dynamicRouteLihat = route('km.nilaiterkirim.index');
            break;
        case 'Teacher':
            $allowedRoutes = ['guru.km.kirimnilaiakhir.*', 'guru.km.nilaiterkirim.*'];

            $checkRouteKirim = request()->routeIs('guru.km.kirimnilaiakhir.*');
            $dynamicRouteKirim = route('guru.km.kirimnilaiakhir.index');

            $checkRouteLihat = request()->routeIs('guru.km.nilaiterkirim.*');
            $dynamicRouteLihat = route('guru.km.nilaiterkirim.index');
            break;
        default:
    }

@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs($allowedRoutes),
    'hasArrow' => true,
    'icon' => 'send',
    'itemName' => 'Nilai Akhir',
    'route' => 'javascript:void(0)',
    'subItems' => [
        [
            'name' => 'Kirim Nilai Akhir',
            'route' => $dynamicRouteKirim,
            'isActive' => $checkRouteKirim,
            'childHasArrow' => false,
        ],
        [
            'name' => 'Lihat Nilai Terkirim',
            'route' => $dynamicRouteLihat,
            'isActive' => $checkRouteLihat,
            'childHasArrow' => false,
        ],
    ],
])
