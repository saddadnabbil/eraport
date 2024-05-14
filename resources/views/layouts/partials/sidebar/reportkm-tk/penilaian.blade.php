@php
    $userRole = Auth::user()->getRoleNames()->first();

    $checkRoute = request()->routeIs('tk.penilaian.*');
    $dynamicRoute = route('tk.penilaian.index');
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'clipboard',
    'itemName' => 'Penilaiaan',
    'route' => $dynamicRoute,
])
