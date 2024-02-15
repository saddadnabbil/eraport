@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 2:
            $checkRoute = request()->routeIs('guru.jadwalMengajar.*');
            $dynamicRoute = route('guru.jadwalMengajar');
            break;
        case 3:
            $checkRoute = request()->routeIs('siswa.jadwalPelajaran.*');
            $dynamicRoute = route('siswa.jadwalPelajaran');
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
