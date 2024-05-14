@php
    $userRole = Auth::user()->getRoleNames()->first();

    $checkRoute = request()->routeIs('tk.event.*');
    $dynamicRoute = route('tk.event.index');
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'clipboard',
    'itemName' => 'Events',
    'route' => $dynamicRoute,
])
