@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Teacher':
            $checkRoute = request()->routeIs('statusnilaiguru.*');
            $dynamicRoute = route('walikelas.statusnilaiguru.index');
            break;
    }
@endphp


@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs('statusnilaiguru.*'),
    'hasArrow' => false,
    'icon' => 'users',
    'itemName' => 'Cek Status Penilaian',
    'route' => route('walikelas.statusnilaiguru.index'),
])
