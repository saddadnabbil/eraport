@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs('penilaiantk.*');
            $dynamicRoute = route('penilaiantk.index');
            break;
        case 'Teacher':
            $checkRoute = request()->routeIs('guru.penilaiantk.*');
            $dynamicRoute = route('guru.penilaiantk.index');
            break;
        // case 'Student':
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
