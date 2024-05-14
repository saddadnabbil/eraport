@php
    $userRole = Auth::user()->getRoleNames()->first();

    $checkRoute = route('user.index');
    $dynamicRoute = route('user.index');

@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs([
        'km.tglraport.*',
        'km.kkm.*',
        'km.mapping.*',
        'km.kehadiran.*',
        'km.prestasi.*',
        'km.catatan.*',
        'km.kenaikan.*',
    ]),
    'hasArrow' => true,
    'icon' => 'clipboard',
    'itemName' => 'Input Data',
    'route' => 'javascript:void(0)',
    'subItems' => [
        [
            'name' => 'Minimum Criteria',
            'route' => route('km.kkm.index'),
            'isActive' => request()->routeIs('km.kkm.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Mapping Subject',
            'route' => route('km.mapping.index'),
            'isActive' => request()->routeIs('km.mapping.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Kehadiran Siswa',
            'route' => route('km.kehadiran.index'),
            'isActive' => request()->routeIs('km.kehadiran.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Prestasi Siswa',
            'route' => route('km.prestasi.index'),
            'isActive' => request()->routeIs('km.prestasi.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Catatan Wali Kelas',
            'route' => route('km.catatan.index'),
            'isActive' => request()->routeIs('km.catatan.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Tanggal Raport',
            'route' => route('km.tglraport.index'),
            'isActive' => request()->routeIs('km.tglraport.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Kenaikan Kelas',
            'route' => route('km.kenaikan.index'),
            'isActive' => request()->routeIs('km.kenaikan.*'),
            'childHasArrow' => false,
        ],
    ],
])
