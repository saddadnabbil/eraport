@php
    $userRole = Auth::user()->getRoleNames()->first();
    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs('tk.event.*');
            $dynamicRoute = route('tk.event.index');
            break;
        case 'Teacher PG-KG' or 'Co-Teacher PG-KG' or 'Curriculum':
            $checkRoute = request()->routeIs('guru.tk.event.*');
            $dynamicRoute = route('guru.tk.event.index');
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
    'icon' => 'clipboard',
    'itemName' => 'Events',
    'route' => $dynamicRoute,
])
