@php
    $userRole = Auth::user()->getRoleNames()->first();

    $checkRoute = request()->routeIs('km.nilaiekstra.*');
    $dynamicRoute = route('km.nilaiekstra.index');
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'plus-circle',
    'itemName' => 'Nilai Ekstrakulikuler',
    'route' => $dynamicRoute,
])
