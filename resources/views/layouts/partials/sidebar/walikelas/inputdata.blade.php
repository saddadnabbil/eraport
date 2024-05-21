@php
    $userRole = Auth::user()->getRoleNames()->first();
    switch ($userRole) {
        case 'Teacher':
            $checkRoute = route('user.index');
            $dynamicRoute = route('user.index');
            break;
    }
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
            'name' => 'Kehadiran Siswa',
            'route' => route('walikelas.kehadiran.index'),
            'isActive' => request()->routeIs('walikelas.kehadiran.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Prestasi Siswa',
            'route' => route('walikelas.prestasi.index'),
            'isActive' => request()->routeIs('walikelas.prestasi.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Catatan Wali Kelas',
            'route' => route('walikelas.catatan.index'),
            'isActive' => request()->routeIs('walikelas.catatan.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Kenaikan Kelas',
            'route' => route('walikelas.kenaikan.index'),
            'isActive' => request()->routeIs('walikelas.kenaikan.*'),
            'childHasArrow' => false,
        ],
    ],
])
