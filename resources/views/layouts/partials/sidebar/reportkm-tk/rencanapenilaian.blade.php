@php
    $userRole = Auth::user()->role;

    switch ($userRole) {
        case 1:
            $checkRoute = route('user.index');
            $dynamicRoute = route('user.index');
            break;
        case 2:
            $checkRoute = route('user.index');
            $dynamicRoute = route('user.index');
            break;
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs([
        'tglraportkm.*',
        'kkmadmin.*',
        'mappingkm.*',
        'kehadiranadmin.*',
        'prestasiadmin.*',
        'catatanadmin.*',
        'kenaikanadmin.*',
    ]),
    'hasArrow' => true,
    'icon' => 'clipboard',
    'itemName' => 'Input Data',
    'route' => 'javascript:void(0)',
    'subItems' => [
        [
            'name' => 'Elements',
            'route' => route('kehadiranadmin.index'),
            'isActive' => request()->routeIs('kehadiranadmin.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Topics',
            'route' => route('prestasiadmin.index'),
            'isActive' => request()->routeIs('prestasiadmin.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Subtopics',
            'route' => route('catatanadmin.index'),
            'isActive' => request()->routeIs('catatanadmin.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Points',
            'route' => route('catatanadmin.index'),
            'isActive' => request()->routeIs('catatanadmin.*'),
            'childHasArrow' => false,
        ],
    ],
])
