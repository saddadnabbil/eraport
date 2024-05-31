@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Teacher' or 'Co-Teacher' or 'Teacher PG-KG' or 'Co-Teacher PG-KG' or 'Curriculum':
            $checkRoute = request()->routeIs('walikelas.leger.*');
            $dynamicRoute = route('walikelas.leger.index');

            break;
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'home',
    'itemName' => 'Leger Student Value',
    'route' => $dynamicRoute,
])
