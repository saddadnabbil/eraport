@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 1:
            $checkRoute = request()->routeIs('nilaiekstraadmin.*');
            $dynamicRoute = route('nilaiekstraadmin.index');
            break;
        case 2:
            $checkRoute = request()->routeIs('nilaiekstra.*');
            $dynamicRoute = route('nilaiekstra.index');
            
            break;
        default:
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'plus-circle',
    'itemName' => 'Nilai Ekstrakulikuler',
    'route' => $dynamicRoute,
])