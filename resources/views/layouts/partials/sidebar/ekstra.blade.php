@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Student':
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
