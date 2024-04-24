@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Teacher':
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
