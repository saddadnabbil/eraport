@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 1:
            $checkRoute = request()->routeIs('user.*');
            $dynamicRoute = route('user.index');
            break;
        case 2:
            $checkRoute = request()->routeIs('user..*');
            $dynamicRoute = route('user.index');
            break;
    }
@endphp


@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs('user.*'),
    'hasArrow' => true,
    'icon' => 'user',
    'itemName' => 'User Data',
    'route' => route('user.index'),
    'subItems' => [
        [
            'name' => 'Status',
            'route' => route('user.index'),
            'isActive' => request()->routeIs('user.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Role',
            'route' => route('role.index'),
            'isActive' => request()->routeIs('role.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Permission',
            'route' => route('permission.index'),
            'isActive' => request()->routeIs('permission.*'),
            'childHasArrow' => false,
        ],
    ],
])
