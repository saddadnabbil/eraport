@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs('penilaiankm.*');
            $dynamicRoute = route('penilaiankm.index');
            break;
        case 'Teacher':
            $checkRoute = request()->routeIs('guru.penilaiankm.*');
            $dynamicRoute = route('guru.penilaiankm.index');

            break;
        default:
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'plus-square',
    'itemName' => 'Penilaian',
    'route' => $dynamicRoute,
])
