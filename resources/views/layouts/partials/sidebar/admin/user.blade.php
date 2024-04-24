@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs('user.*');
            $dynamicRoute = route('user.index');
            break;
        case 'Teacher':
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
            'name' => 'User',
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
