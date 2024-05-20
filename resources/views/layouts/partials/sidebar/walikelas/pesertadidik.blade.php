@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Teacher':
            $checkRoute = request()->routeIs('walikelas.pesertadidik.*');
            $dynamicRoute = route('walikelas.pesertadidik.index');
            break;
    }
@endphp


@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs('walikelas.pesertadidik.*'),
    'hasArrow' => false,
    'icon' => 'users',
    'itemName' => 'Data Peserta Didik',
    'route' => route('walikelas.pesertadidik.index'),
])
