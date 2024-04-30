@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs('p5.project.*');
            $dynamicRoute = route('p5.project.index');
            break;
        case 'Teacher':
            $checkRoute = request()->routeIs('p5.project.*');
            $dynamicRoute = route('p5.project.index');
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'plus-circle',
    'itemName' => 'Manajemen P5BK',
    'route' => $dynamicRoute,
])
