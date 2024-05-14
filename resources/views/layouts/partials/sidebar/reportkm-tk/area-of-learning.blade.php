@php
    $userRole = Auth::user()->getRoleNames()->first();

    $checkRoute = route('user.index');
    $dynamicRoute = route('user.index');
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs([
        'tk.element.*',
        'tk.topic.*',
        'tk.subtopic.*',
        'tk.point.*',
        'tk.pembelajaran.*',
    ]),
    'hasArrow' => true,
    'icon' => 'clipboard',
    'itemName' => 'Area Of Learning',
    'route' => 'javascript:void(0)',
    'subItems' => [
        [
            'name' => 'Elements',
            'route' => route('tk.element.index'),
            'isActive' => request()->routeIs('tk.element.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Topics',
            'route' => route('tk.topic.index'),
            'isActive' => request()->routeIs('tk.topic.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Subtopics',
            'route' => route('tk.subtopic.index'),
            'isActive' => request()->routeIs('tk.subtopic.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Points',
            'route' => route('tk.point.index'),
            'isActive' => request()->routeIs('tk.point.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Set Teacher Topic',
            'route' => route('tk.pembelajaran.index'),
            'isActive' => request()->routeIs('tk.pembelajaran.*'),
            'childHasArrow' => false,
        ],
    ],
])
