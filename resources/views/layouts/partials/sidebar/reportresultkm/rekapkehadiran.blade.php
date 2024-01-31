@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 1:
            $checkRoute = request()->routeIs('rekapkehadiran.*');
            $dynamicRoute = route('rekapkehadiran.index');
            break;
        case 2:
            $checkRoute = request()->routeIs('kehadiran.*');
            $dynamicRoute = route('kehadiran.index');
            break;
        case 3:
            $checkRoute = request()->routeIs('presensi.*');
            $dynamicRoute = route('presensi.index');
            break;
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'home',
    'itemName' => 'Student Attendance',
    'route' => $dynamicRoute,
])