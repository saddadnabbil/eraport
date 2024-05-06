@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $allowedRoutes = ['adminraportptskm.*', 'adminraportsemesterkm.*'];

            $checkRouteMidSemesterReport = request()->routeIs('adminraportptskm.*');
            $dynamicRouteMidSemesterReport = route('adminraportptskm.index');

            $checkRouteSemesterReport = request()->routeIs('adminraportsemesterkm.*');
            $dynamicRouteSemesterReport = route('adminraportsemesterkm.index');

            $checkRouteSemesterReport = request()->routeIs('p5.raport.*');
            $dynamicRouteSemesterReport = route('p5.raport.index');
            break;
        case 'Teacher':
            $allowedRoutes = ['kirimnilaiakhirkm.*', 'kirimnilaiakhirkm.*'];

            $checkRouteMidSemesterReport = request()->routeIs('statusnilaiguru.*');
            $dynamicRouteMidSemesterReport = route('statusnilaiguru.index');

            $checkRouteSemesterReport = request()->routeIs('adminraportsemesterkm.*');
            $dynamicRouteSemesterReport = route('adminraportsemesterkm.index');

            $checkRouteSemesterReport = request()->routeIs('p5.raport.*');
            $dynamicRouteSemesterReport = route('p5.raport.*');
            break;
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs($allowedRoutes),
    'hasArrow' => true,
    'icon' => 'file',
    'itemName' => 'Print Report',
    'route' => 'javascript:void(0)',
    'subItems' => [
        [
            'name' => 'Mid-Semester Report',
            'route' => $dynamicRouteMidSemesterReport,
            'isActive' => $checkRouteMidSemesterReport,
            'childHasArrow' => false,
        ],
        [
            'name' => 'Semester Report',
            'route' => $dynamicRouteSemesterReport,
            'isActive' => $checkRouteSemesterReport,
            'childHasArrow' => false,
        ],
        [
            'name' => 'P5BK Report',
            'route' => $dynamicRouteSemesterReport,
            'isActive' => $checkRouteSemesterReport,
            'childHasArrow' => false,
        ],
    ],
])
