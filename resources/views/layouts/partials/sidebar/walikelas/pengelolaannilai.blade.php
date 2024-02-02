@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 2:
            $checkRoute = request()->routeIs('hasilnilai.*');
            $dynamicRoute = route('hasilnilai.index');
            break;
    }
@endphp


@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs('hasilnilai.*'),
    'hasArrow' => false,
    'icon' => 'users',
    'itemName' => 'Pengelolaan Nilai',
    'route' => route('hasilnilai.index'),
])