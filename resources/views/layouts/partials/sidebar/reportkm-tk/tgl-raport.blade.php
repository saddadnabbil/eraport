@php
    $userRole = Auth::user()->getRoleNames()->first();
    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs('tk.tglraport.*');
            $dynamicRoute = route('tk.tglraport.index');
            break;
        case 'Teacher':
            $checkRoute = request()->routeIs('guru.tk.tglraport.*');
            $dynamicRoute = route('guru.tk.tglraport.index');
            break;
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'clipboard',
    'itemName' => 'Tanggal Raport',
    'route' => $dynamicRoute,
])
