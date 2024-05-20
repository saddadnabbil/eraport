@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Teacher':
            $checkRoute = request()->routeIs('walikelas.hasilnilai.*');
            $dynamicRoute = route('walikelas.hasilnilai.index');
            break;
    }
@endphp


@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs('walikelas.hasilnilai.*'),
    'hasArrow' => false,
    'icon' => 'users',
    'itemName' => 'Pengelolaan Nilai',
    'route' => route('walikelas.hasilnilai.index'),
])
