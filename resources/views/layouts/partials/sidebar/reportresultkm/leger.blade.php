@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs('adminlegerkm.*');
            $dynamicRoute = route('adminlegerkm.index');
            break;
        case 'Teacher':
            $checkRoute = request()->routeIs('leger.*');
            $dynamicRoute = route('leger.index');
        case 'Student':
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
