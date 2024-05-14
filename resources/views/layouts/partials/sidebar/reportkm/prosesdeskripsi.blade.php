@php
    $userRole = Auth::user()->getRoleNames()->first();

    $checkRoute = request()->routeIs('km.prosesdeskripsi.*');
    $dynamicRoute = route('km.prosesdeskripsi.index');
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'file-plus',
    'itemName' => 'Deskripsi Siswa',
    'route' => $dynamicRoute,
])
