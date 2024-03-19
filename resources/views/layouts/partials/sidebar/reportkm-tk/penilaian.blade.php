@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 1:
            $checkRoute = request()->routeIs('penilaiantk.*');
            $dynamicRoute = route('penilaiantk.index');
            break;
        // case 2:
        //     $checkRoute = request()->routeIs('guru.silabus.*');
        //     $dynamicRoute = route('guru.silabus.index');
        //     break;
        // case 3:
        //     $checkRoute = request()->routeIs('siswa.silabus.*');
        //     $dynamicRoute = route('siswa.silabus.index');
        //     break;
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'clipboard',
    'itemName' => 'Penilaiaan',
    'route' => $dynamicRoute,
])
