@php
    $inputDataSubItems = [
        [
            'name' => 'Minimum Criteria',
            'route' => route('guru.km.kkm.index'),
            'isActive' => request()->routeIs('guru.km.kkm.*'),
            'childHasArrow' => false,
        ],
        [
            'name' => 'Mapping Subject',
            'route' => route('guru.km.mapping.index'),
            'isActive' => request()->routeIs('guru.km.mapping.*'),
            'childHasArrow' => false,
        ],
    ];
@endphp

@if (auth()->user()->hasAnyPermission(['homeroom-km']) && session('akses_sebagai') == 'homeroom-km')
    @php
        $inputDataSubItems = array_slice($inputDataSubItems, 2, 4);
    @endphp
@endif

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs([
        'km.tglraport.*',
        'km.kkm.*',
    ]),
    'hasArrow' => true,
    'icon' => 'clipboard',
    'itemName' => 'Input Data',
    'route' => 'javascript:void(0)',
    'subItems' => $inputDataSubItems,
])
