@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $allowedRoutes = ['kirimnilaiakhirkmadmin.*', 'nilaiterkirimkmadmin.*'];

            $checkRouteKirim = request()->routeIs('kirimnilaiakhirkmadmin.*');
            $dynamicRouteKirim = route('kirimnilaiakhirkmadmin.index');

            $checkRouteLihat = request()->routeIs('nilaiterkirimkmadmin.*');
            $dynamicRouteLihat = route('nilaiterkirimkmadmin.index');

            break;
        case 'Teacher':
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
