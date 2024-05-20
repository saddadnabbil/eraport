@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Teacher':
            $allowedRoutes = ['raportptskm.*', 'raportsemesterkm.*'];

            $checkRouteMidSemesterReport = request()->routeIs('raportptskm.*');
            $dynamicRouteMidSemesterReport = route('walikelas.raportptskm.index');

            $checkRouteSemesterReport = request()->routeIs('raportsemesterkm.*');
            $dynamicRouteSemesterReport = route('walikelas.raportsemesterkm.index');
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
    ],
])
