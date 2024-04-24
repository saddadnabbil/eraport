@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Teacher':
            $checkRoute = request()->routeIs('guru.jadwalmengajar.*');
            $dynamicRoute = route('guru.jadwalmengajar');
            break;
        case 'Student':
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
