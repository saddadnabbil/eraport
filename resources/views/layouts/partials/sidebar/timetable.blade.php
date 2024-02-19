@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 2:
            $checkRoute = request()->routeIs('guru.jadwalmengajar.*');
            $dynamicRoute = route('guru.jadwalmengajar');
            break;
        case 3:
            $checkRoute = request()->routeIs('siswa.jadwalpelajaran.*');
            $dynamicRoute = route('siswa.jadwalpelajaran');
            break;
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'plus-circle',
    'itemName' => 'Timetable',
    'route' => $dynamicRoute,
])
