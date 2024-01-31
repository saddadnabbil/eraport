@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 1:
            $allowedRoutes = ['kirimnilaiakhirkmadmin.*', 'nilaiterkirimkmadmin.*'];

            $checkRouteKirim = request()->routeIs('kirimnilaiakhirkmadmin.*');
            $dynamicRouteKirim = route('kirimnilaiakhirkmadmin.index');

            $checkRouteLihat = request()->routeIs('nilaiterkirimkmadmin.*');
            $dynamicRouteLihat = route('nilaiterkirimkmadmin.index');
            
            break;
        case 2:
            $allowedRoutes = ['kirimnilaiakhirkm.*', 'kirimnilaiakhirkm.*'];
            
            $checkRouteKirim = request()->routeIs('kirimnilaiakhirkm.*');
            $dynamicRouteKirim = route('kirimnilaiakhirkm.index');

            $checkRouteLihat = request()->routeIs('nilaiterkirimkm.*');
            $dynamicRouteLihat = route('nilaiterkirimkm.index');
            
            break;
        default:
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs($allowedRoutes),
    'hasArrow' => true,
    'icon' => 'check-square',
    'itemName' => 'Nilai Akhir',
    'route' => 'javascript:void(0)',
    'subItems' => [
        [
            'name' => 'Kirim Nilai Akhir',
            'route' => $dynamicRouteKirim,
            'isActive' => $checkRouteKirim,
        ],
        [
            'name' => 'Lihat Nilai Terkirim',
            'route' => $dynamicRouteLihat,
            'isActive' => $checkRouteLihat,
        ],
    ],
])