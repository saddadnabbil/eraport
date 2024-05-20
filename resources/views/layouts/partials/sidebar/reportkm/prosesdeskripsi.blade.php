@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs('km.prosesdeskripsi.*');
            $dynamicRoute = route('km.prosesdeskripsi.index');
            break;
        case 'Teacher':
            $checkRoute = request()->routeIs('guru.km.prosesdeskripsi.*');
            $dynamicRoute = route('guru.km.prosesdeskripsi.index');
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
