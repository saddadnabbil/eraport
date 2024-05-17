@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Student':
            $checkRoute = request()->routeIs('nilaiakhir.*');
            $dynamicRoute = route('nilaiakhir.index');
            break;
        case 'Admin' || 'Teacher':
            $checkRoute = request()->routeIs('km.leger.*');
            $dynamicRoute = route('km.leger.index');
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
