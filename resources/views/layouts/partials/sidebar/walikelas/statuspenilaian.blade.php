@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 2:
            $checkRoute = request()->routeIs('statusnilaiguru.*');
            $dynamicRoute = route('statusnilaiguru.index');
            break;
    }
@endphp


@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs('statusnilaiguru.*'),
    'hasArrow' => false,
    'icon' => 'users',
    'itemName' => 'Cek Status Penilaian',
    'route' => route('statusnilaiguru.index'),
])