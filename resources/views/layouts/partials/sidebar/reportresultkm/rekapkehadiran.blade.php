@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs('rekapkehadiran.*');
            $dynamicRoute = route('rekapkehadiran.index');
            break;
        case 'Teacher':
            $checkRoute = request()->routeIs('kehadiran.*');
            $dynamicRoute = route('kehadiran.index');
            break;
        case 'Student':
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
