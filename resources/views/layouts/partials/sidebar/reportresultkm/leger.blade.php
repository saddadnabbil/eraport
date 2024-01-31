@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 1:
            $checkRoute = request()->routeIs('adminlegerkm.*');
            $dynamicRoute = route('adminlegerkm.index');
            break;
        case 2:
            $checkRoute = request()->routeIs('leger.*');
            $dynamicRoute = route('leger.index');
            
            break;
        default:
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'home',
    'itemName' => 'Leger Student Value',
    'route' => $dynamicRoute,
])