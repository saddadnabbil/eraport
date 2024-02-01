@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 3:
            $checkRoute = request()->routeIs('ekstra.*');
            $dynamicRoute = route('ekstra.index');
            break;
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'plus-circle',
    'itemName' => 'Ekstrakulikuler',
    'route' => $dynamicRoute,
])