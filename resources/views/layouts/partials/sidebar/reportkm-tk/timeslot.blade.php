@php
    $userRole = Auth::user()->getRoleNames()->first();
    switch ($userRole) {
        case 'Admin':
            $allowedRoutes = ['admin.tk.jadwalpelajaran.*', 'admin.tk.jadwalmengajar.*', 'admin.tk.timeslot.*'];

            $checkRouteTimeSlot = request()->routeIs('admin.tk.timeslot.*');
            $dynamicRouteTimeSlot = route('admin.tk.timeslot.index');

            $checkRouteTimetable = request()->routeIs('admin.tk.jadwalpelajaran.*');
            $dynamicRouteTimetable = route('admin.tk.jadwalpelajaran.index');

            $checkRouteMengajar = request()->routeIs('admin.tk.jadwalmengajar.*');
            $dynamicRouteMengajar = route('admin.tk.jadwalmengajar.index');
            break;
        case 'Teacher PG-KG' or 'Co-Teacher PG-KG' or 'Curriculum':
            $allowedRoutes = ['guru.tk.jadwalpelajaran.*', 'guru.tk.jadwalmengajar.*', 'guru.tk.timeslot.*'];

            $checkRouteTimeSlot = request()->routeIs('guru.tk.timeslot.*');
            $dynamicRouteTimeSlot = route('guru.tk.timeslot.index');

            $checkRouteTimetable = request()->routeIs('guru.tk.jadwalpelajaran.*');
            $dynamicRouteTimetable = route('guru.tk.jadwalpelajaran.index');

            $checkRouteMengajar = request()->routeIs('guru.tk.jadwalmengajar.*');
            $dynamicRouteMengajar = route('guru.tk.jadwalmengajar.index');
            break;
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs($allowedRoutes),
    'hasArrow' => true,
    'icon' => 'clipboard',
    'itemName' => 'TimeTable',
    'route' => 'javascript:void(0)',
    'subItems' => [
        [
            'name' => 'Timeslot',
            'route' => $dynamicRouteTimeSlot,
            'isActive' => $checkRouteTimeSlot,
            'childHasArrow' => false,
        ],
        [
            'name' => 'Timetable',
            'route' => $dynamicRouteTimetable,
            'isActive' => $checkRouteTimetable,
            'childHasArrow' => false,
        ],
        [
            'name' => 'Timetable Teacher',
            'route' => $dynamicRouteMengajar,
            'isActive' => $checkRouteMengajar,
            'childHasArrow' => false,
        ],
    ],
])
