@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 1:
            $checkRoute = request()->routeIs('penilaiankm.*');
            $dynamicRoute = route('penilaiankm.index');
            break;
        case 2:
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