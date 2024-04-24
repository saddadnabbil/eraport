@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs('prosesdeskripsikmadmin.*');
            $dynamicRoute = route('prosesdeskripsikmadmin.index');
            break;
        case 'Teacher':
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
    'itemName' => 'Deskripsi Siswa',
    'route' => $dynamicRoute,
])
