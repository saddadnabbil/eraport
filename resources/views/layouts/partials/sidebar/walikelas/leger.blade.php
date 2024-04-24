@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Teacher':
            $checkRoute = request()->routeIs('leger.*');
            $dynamicRoute = route('leger.index');

            break;
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'home',
    'itemName' => 'Leger Student Value',
    'route' => $dynamicRoute,
])
