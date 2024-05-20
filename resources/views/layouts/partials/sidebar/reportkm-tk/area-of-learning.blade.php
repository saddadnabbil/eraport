@php
    $userRole = Auth::user()->getRoleNames()->first();
    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs([
                'tk.element.*',
                'tk.topic.*',
                'tk.subtopic.*',
                'tk.point.*',
                'tk.pembelajaran.*',
            ]);

            $dynamicElement = route('tk.element.index');
            $dynamicTopic = route('tk.topic.index');
            $dynamicSubtopic = route('tk.subtopic.index');
            $dynamicPoint = route('tk.point.index');
            $dynamicPembelajaran = route('tk.pembelajaran.index');

            $checkElement = request()->routeIs('tk.element.*');
            $checkTopic = request()->routeIs('tk.topic.*');
            $checkSubtopic = request()->routeIs('tk.subtopic.*');
            $checkPoint = request()->routeIs('tk.point.*');
            $checkPembelajaran = request()->routeIs('tk.pembelajaran.*');
            break;
        case 'Teacher':
            $checkRoute = request()->routeIs([
                'guru.tk.element.*',
                'guru.tk.topic.*',
                'guru.tk.subtopic.*',
                'guru.tk.point.*',
                'guru.tk.pembelajaran.*',
            ]);

            $dynamicElement = route('guru.tk.element.index');
            $dynamicTopic = route('guru.tk.topic.index');
            $dynamicSubtopic = route('guru.tk.subtopic.index');
            $dynamicPoint = route('guru.tk.point.index');
            $dynamicPembelajaran = route('guru.tk.pembelajaran.index');

            $checkElement = request()->routeIs('guru.tk.element.*');
            $checkTopic = request()->routeIs('guru.tk.topic.*');
            $checkSubtopic = request()->routeIs('guru.tk.subtopic.*');
            $checkPoint = request()->routeIs('guru.tk.point.*');
            $checkPembelajaran = request()->routeIs('guru.tk.pembelajaran.*');
            break;
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => true,
    'icon' => 'clipboard',
    'itemName' => 'Area Of Learning',
    'route' => 'javascript:void(0)',
    'subItems' => [
        [
            'name' => 'Elements',
            'route' => $dynamicElement,
            'isActive' => $checkElement,
            'childHasArrow' => false,
        ],
        [
            'name' => 'Topics',
            'route' => $dynamicTopic,
            'isActive' => $checkTopic,
            'childHasArrow' => false,
        ],
        [
            'name' => 'Subtopics',
            'route' => $dynamicSubtopic,
            'isActive' => $checkSubtopic,
            'childHasArrow' => false,
        ],
        [
            'name' => 'Points',
            'route' => $dynamicPoint,
            'isActive' => $checkPoint,
            'childHasArrow' => false,
        ],
        [
            'name' => 'Set Teacher Topic',
            'route' => $dynamicPembelajaran,
            'isActive' => $checkPembelajaran,
            'childHasArrow' => false,
        ],
    ],
])
