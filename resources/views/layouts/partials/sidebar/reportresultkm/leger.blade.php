@php
    $userRole = Auth::user()->getRoleNames()->first();

    $checkRoute = request()->routeIs('km.leger.*');
    $dynamicRoute = route('km.leger.index');

@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'home',
    'itemName' => $userRole == 3 ? 'Report Leger Student Value' : 'Leger Student Value',
    'route' => $dynamicRoute,
])
