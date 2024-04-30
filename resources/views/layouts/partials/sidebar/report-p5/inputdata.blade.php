@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $allowedRoutes = ['p5.dimensi.*', 'p5.element.*', 'p5.subelement.*'];

            $checkRouteDimensi = request()->routeIs('p5.dimensi.*');
            $dynamicRouteDimensi = route('p5.dimensi.index');

            $checkRouteElement = request()->routeIs('p5.element.*');
            $dynamicRouteElement = route('p5.element.index');

            $checkRouteSubelement = request()->routeIs('p5.subelement.*');
            $dynamicRouteSubelement = route('p5.subelement.index');

            $checkRouteTema = request()->routeIs('p5.tema.*');
            $dynamicRouteTema = route('p5.tema.index');
            break;
        case 'Teacher':
            $allowedRoutes = ['p5.dimensi.*', 'p5.element.*', 'p5.subelement.*'];

            $checkRouteDimensi = request()->routeIs('p5.dimensi.*');
            $dynamicRouteDimensi = route('p5.dimensi.index');

            $checkRouteElement = request()->routeIs('p5.element.*');
            $dynamicRouteElement = route('p5.element.index');

            $checkRouteSubelement = request()->routeIs('p5.subelement.*');
            $dynamicRouteSubelement = route('p5.subelement.index');

            $checkRouteTema = request()->routeIs('p5.tema.*');
            $dynamicRouteTema = route('p5.tema.index');
            break;
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs($allowedRoutes),
    'hasArrow' => true,
    'icon' => 'clipboard',
    'itemName' => 'Input Data',
    'route' => 'javascript:void(0)',
    'subItems' => [
        [
            'name' => 'Dimensi',
            'route' => $dynamicRouteDimensi,
            'isActive' => $checkRouteDimensi,
            'childHasArrow' => false,
        ],
        [
            'name' => 'Element',
            'route' => $dynamicRouteElement,
            'isActive' => $checkRouteElement,
            'childHasArrow' => false,
        ],
        [
            'name' => 'Subelement',
            'route' => $dynamicRouteSubelement,
            'isActive' => $checkRouteSubelement,
            'childHasArrow' => false,
        ],
        [
            'name' => 'Tema',
            'route' => $dynamicRouteTema,
            'isActive' => $checkRouteTema,
            'childHasArrow' => false,
        ],
    ],
])
