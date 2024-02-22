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
        case 3:
            $checkRoute = request()->routeIs('nilaiakhir.*');
            $dynamicRoute = route('nilaiakhir.index');

            break;
        default:
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'home',
    'itemName' => $userRole == 3 ? 'Report Leger Student Value' : 'Leger Student Value',
    'route' => $dynamicRoute,
])
