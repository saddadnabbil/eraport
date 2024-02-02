@php
    $userRole = Auth::user()->role;
    switch ($userRole) {
        case 2:
            $checkRoute = route('user.index');
            $dynamicRoute = route('user.index');
            break;
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs(['tglraportkm.*', 'kkmadmin.*', 'mappingkm.*', 'kehadiranadmin.*', 'prestasiadmin.*', 'catatanadmin.*', 'kenaikanadmin.*']),
    'hasArrow' => true,
    'icon' => 'clipboard',
    'itemName' => 'Input Data',
    'route' => 'javascript:void(0)',
    'subItems' => [
        [
            'name' => 'Kehadiran Siswa',
            'route' => route('kehadiran.index'),
            'isActive' => request()->routeIs('kehadiran.*'),
        ],
        [
            'name' => 'Prestasi Siswa',
            'route' => route('prestasi.index'),
            'isActive' => request()->routeIs('prestasi.*'),
        ],
        [
            'name' => 'Catatan Wali Kelas',
            'route' => route('catatan.index'),
            'isActive' => request()->routeIs('catatan.*'),
        ],
        [
            'name' => 'Kenaikan Kelas',
            'route' => route('kenaikan.index'),
            'isActive' => request()->routeIs('kenaikan.*'),
        ],
    ],
])