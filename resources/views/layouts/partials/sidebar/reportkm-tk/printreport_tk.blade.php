@php
    $userRole = Auth::user()->getRoleNames()->first();

    $allowedRoutes = ['tk.raport.*'];
    $checkRouteTKReport = request()->routeIs('tk.raport.*');
    $dynamicRouteTKReport = route('tk.raport.index');

@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs($allowedRoutes),
    'hasArrow' => false,
    'icon' => 'file',
    'itemName' => 'Print Report TK',
    'route' => $dynamicRouteTKReport,
])
