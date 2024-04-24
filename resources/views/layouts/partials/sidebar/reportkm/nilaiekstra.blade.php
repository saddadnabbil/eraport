@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs('nilaiekstraadmin.*');
            $dynamicRoute = route('nilaiekstraadmin.index');
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
