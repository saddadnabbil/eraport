@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 1:
            $checkRoute = route('user.index');
            $dynamicRoute = route('user.index');
            break;
        case 2:
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
            'name' => 'Kehadiran Siswa',
            'route' => route('kehadiranadmintk.index'),
            'isActive' => request()->routeIs('kehadiranadmintk.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Event Siswa',
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
    ],
])
