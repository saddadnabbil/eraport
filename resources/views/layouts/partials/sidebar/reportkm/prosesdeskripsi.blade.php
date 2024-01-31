@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 1:
            $checkRoute = request()->routeIs('prosesdeskripsikmadmin.*');
            $dynamicRoute = route('prosesdeskripsikmadmin.index');
            break;
        case 2:
            $checkRoute = request()->routeIs('prosesdeskripsikm.*');
            $dynamicRoute = route('prosesdeskripsikm.index');
            
            break;
        default:
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'file-plus',
    'itemName' => 'Proses Deskripsi Siswa',
    'route' => $dynamicRoute,
])