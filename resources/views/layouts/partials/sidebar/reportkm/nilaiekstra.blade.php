@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs('km.nilaiekstra.*');
            $dynamicRoute = route('km.nilaiekstra.index');
            break;
        case 'Teacher':
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
