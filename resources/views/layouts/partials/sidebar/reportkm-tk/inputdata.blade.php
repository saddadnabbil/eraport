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
    'isActive' => request()->routeIs(['kehadiranadmintk.*', 'rekapevent.*', 'catatanadmintk.*']),
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
            'route' => route('rekapevent.index'),
            'isActive' => request()->routeIs('rekapevent.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Catatan Wali Kelas',
            'route' => route('catatanadmintk.index'),
            'isActive' => request()->routeIs('catatanadmintk.*'),
            'childHasArrow' => false,
        ],
    ],
])
