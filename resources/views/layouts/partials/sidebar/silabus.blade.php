@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs('admin.silabus.*');
            $dynamicRoute = route('admin.silabus.index');
            break;
        case 'Teacher':
            $checkRoute = request()->routeIs('guru.silabus.*');
            $dynamicRoute = route('guru.silabus.index');
            break;
        case 'Student':
            $checkRoute = request()->routeIs('siswa.silabus.*');
            $dynamicRoute = route('siswa.silabus.index');
            break;
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'plus-circle',
    'itemName' => 'Silabus',
    'route' => $dynamicRoute,
])
