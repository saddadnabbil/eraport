@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 1:
            $checkRoute = request()->routeIs('user.index');
            $dynamicRoute = route('user.index');
            break;
        case 2:
            $checkRoute = request()->routeIs('user.index');
            $dynamicRoute = route('user.index');
            break;
    }
@endphp


@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs('user.*'),
    'hasArrow' => false,
    'icon' => 'user',
    'itemName' => 'User Data',
    'route' => route('user.index'),
])