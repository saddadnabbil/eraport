@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 2:
            $checkRoute = request()->routeIs('pesertadidik.*');
            $dynamicRoute = route('pesertadidik.index');
            break;
    }
@endphp


@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs('pesertadidik.*'),
    'hasArrow' => false,
    'icon' => 'users',
    'itemName' => 'Data Peserta Didik',
    'route' => route('pesertadidik.index'),
])