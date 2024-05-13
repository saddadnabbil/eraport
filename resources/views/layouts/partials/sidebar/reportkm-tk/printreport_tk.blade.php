@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $allowedRoutes = ['tk.raport.*'];

            $checkRouteTKReport = request()->routeIs('tk.raport.*');
            $dynamicRouteTKReport = route('tk.raport.index');
            break;
        case 'Teacher':
            $allowedRoutes = ['guru.raport.*', 'guru.raport.*'];

            $checkRouteTKReport = request()->routeIs('guru.raport.*');
            $dynamicRouteTKReport = route('guru.raport.index');
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
