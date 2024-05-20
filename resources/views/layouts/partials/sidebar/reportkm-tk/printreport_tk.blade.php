@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $allowedRoutes = ['tk.raport.*'];

            $checkRouteTKReport = request()->routeIs('tk.raport.*');
            $dynamicRouteTKReport = route('tk.raport.index');
            break;
        case 'Teacher':
            $allowedRoutes = ['guru.tk.raport*', 'guru.tk.raport*'];

            $checkRouteTKReport = request()->routeIs('guru.tk.raport*');
            $dynamicRouteTKReport = route('guru.tk.raport.index');
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
