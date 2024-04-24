@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $allowedRoutes = ['adminraporttk.*'];

            $checkRouteTKReport = request()->routeIs('adminraporttk.*');
            $dynamicRouteTKReport = route('adminraporttk.index');
            break;
        case 'Teacher':
            $allowedRoutes = ['guru.raporttk.*', 'guru.raporttk.*'];

            $checkRouteTKReport = request()->routeIs('guru.raporttk.*');
            $dynamicRouteTKReport = route('guru.raporttk.index');
            break;
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs($allowedRoutes),
    'hasArrow' => false,
    'icon' => 'file',
    'itemName' => 'Print Report TK',
    'route' => $dynamicRouteTKReport,
])
