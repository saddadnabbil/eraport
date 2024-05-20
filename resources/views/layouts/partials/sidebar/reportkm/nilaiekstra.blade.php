@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs('km.nilaiekstra.*');
            $dynamicRoute = route('km.nilaiekstra.index');
            break;
        case 'Teacher':
            $checkRoute = request()->routeIs('guru.km.nilaiekstra.*');
            $dynamicRoute = route('guru.km.nilaiekstra.index');
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
