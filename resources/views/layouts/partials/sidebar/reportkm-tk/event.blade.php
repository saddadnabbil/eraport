@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs('tk.event.*');
            $dynamicRoute = route('tk.event.index');
            break;
        case 'Teacher':
            $checkRoute = request()->routeIs('tk.event.*');
            $dynamicRoute = route('tk.event.index');
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
