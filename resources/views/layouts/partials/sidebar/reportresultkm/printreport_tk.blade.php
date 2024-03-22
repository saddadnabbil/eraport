@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 1:
            $allowedRoutes = ['adminraporttk.*'];

            $checkRouteTKReport = request()->routeIs('adminraporttk.*');
            $dynamicRouteTKReport = route('adminraporttk.index');
        case 2:
            $allowedRoutes = ['adminraporttk.*', 'adminraporttk.*'];

            $checkRouteTKReport = request()->routeIs('adminraporttk.*');
            $dynamicRouteTKReport = route('adminraporttk.index');
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs($allowedRoutes),
    'hasArrow' => false,
    'icon' => 'file',
    'itemName' => 'Print Report TK',
    'route' => $dynamicRouteTKReport,
])
