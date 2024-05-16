@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Student':
            $checkRoute = request()->routeIs('presensi.*');
            $dynamicRoute = route('presensi.index');
            break;
        default:
            $checkRoute = request()->routeIs('km.rekapkehadiran.*');
            $dynamicRoute = route('km.rekapkehadiran.index');
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'home',
    'itemName' => 'Student Attendance',
    'route' => $dynamicRoute,
])
