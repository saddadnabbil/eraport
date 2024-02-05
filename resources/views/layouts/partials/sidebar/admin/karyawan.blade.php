@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs(['statuskaryawan.*', 'statuskaryawan.*']),
    'hasArrow' => true,
    'icon' => 'database',
    'itemName' => 'Employeement',
    'route' => 'javascript:void(0)',
    'subItems' => [
        [
            'name' => 'Status',
            'route' => route('statuskaryawan.index'),
            'isActive' => request()->routeIs('statuskaryawan.*'),
        ],
        [
            'name' => 'Unit',
            'route' => route('unitkaryawan.index'),
            'isActive' => request()->routeIs('unitkaryawan.*'),
        ],
        [
            'name' => 'Position',
            'route' => route('positionkaryawan.index'),
            'isActive' => request()->routeIs('positionkaryawan.*'),
        ],
        [
            'name' => 'Employee',
            'route' => route('karyawan.index'),
            'isActive' => request()->routeIs('karyawan.*'),
        ],
    ],
])
