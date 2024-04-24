@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $checkRoute = route('user.index');
            $dynamicRoute = route('user.index');
            break;
        case 'Teacher':
            $checkRoute = route('user.index');
            $dynamicRoute = route('user.index');
            break;
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs([
        'tglraportkm.*',
        'kkmadmin.*',
        'mappingkm.*',
        'kehadiranadmin.*',
        'prestasiadmin.*',
        'catatanadmin.*',
        'kenaikanadmin.*',
    ]),
    'hasArrow' => true,
    'icon' => 'clipboard',
    'itemName' => 'Input Data',
    'route' => 'javascript:void(0)',
    'subItems' => [
        [
            'name' => 'Minimum Criteria',
            'route' => route('kkmadmin.index'),
            'isActive' => request()->routeIs('kkmadmin.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Mapping Subject',
            'route' => route('mappingkm.index'),
            'isActive' => request()->routeIs('mappingkm.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Kehadiran Siswa',
            'route' => route('kehadiranadmin.index'),
            'isActive' => request()->routeIs('kehadiranadmin.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Prestasi Siswa',
            'route' => route('prestasiadmin.index'),
            'isActive' => request()->routeIs('prestasiadmin.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Catatan Wali Kelas',
            'route' => route('catatanadmin.index'),
            'isActive' => request()->routeIs('catatanadmin.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Tanggal Raport',
            'route' => route('tglraportkm.index'),
            'isActive' => request()->routeIs('tglraportkm.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Kenaikan Kelas',
            'route' => route('kenaikanadmin.index'),
            'isActive' => request()->routeIs('kenaikanadmin.*'),
            'childHasArrow' => false,
        ],
    ],
])
