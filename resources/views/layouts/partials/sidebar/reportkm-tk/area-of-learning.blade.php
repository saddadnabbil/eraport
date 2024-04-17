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
        'tkelement.*',
        'tktopic.*',
        'tksubtopic.*',
        'tkpoint.*',
        'tkpembelajaran.*',
    ]),
    'hasArrow' => true,
    'icon' => 'clipboard',
    'itemName' => 'Area Of Learning & Development',
    'route' => 'javascript:void(0)',
    'subItems' => [
        [
            'name' => 'Elements',
            'route' => route('tkelement.index'),
            'isActive' => request()->routeIs('tkelement.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Topics',
            'route' => route('tktopic.index'),
            'isActive' => request()->routeIs('tktopic.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Subtopics',
            'route' => route('tksubtopic.index'),
            'isActive' => request()->routeIs('tksubtopic.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Points',
            'route' => route('tkpoint.index'),
            'isActive' => request()->routeIs('tkpoint.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Set Teacher Topic',
            'route' => route('tkpembelajaran.index'),
            'isActive' => request()->routeIs('tkpembelajaran.*'),
            'childHasArrow' => false,
        ],
    ],
])
