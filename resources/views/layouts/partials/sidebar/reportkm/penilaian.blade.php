@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs('km.penilaian.*');
            $dynamicRoute = route('km.penilaian.index');
            break;
        case 'Teacher':
            $checkRoute = request()->routeIs('guru.km.penilaian.*');
            $dynamicRoute = route('guru.km.penilaian.index');
            break;
        default:
    }

@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'plus-square',
    'itemName' => 'Penilaian',
    'route' => $dynamicRoute,
])
