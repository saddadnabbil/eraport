@php
    $userRole = Auth::user()->getRoleNames()->first();

    $checkRoute = request()->routeIs('km.penilaian.*');
    $dynamicRoute = route('km.penilaian.index');

@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'plus-square',
    'itemName' => 'Penilaian',
    'route' => $dynamicRoute,
])
