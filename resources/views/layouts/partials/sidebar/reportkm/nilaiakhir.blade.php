@php
    $userRole = Auth::user()->getRoleNames()->first();
    $allowedRoutes = ['km.kirimnilaiakhir.*', 'km.nilaiterkirim.*'];

    $checkRouteKirim = request()->routeIs('km.kirimnilaiakhir.*');
    $dynamicRouteKirim = route('km.kirimnilaiakhir.index');

    $checkRouteLihat = request()->routeIs('km.nilaiterkirim.*');
    $dynamicRouteLihat = route('km.nilaiterkirim.index');

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
