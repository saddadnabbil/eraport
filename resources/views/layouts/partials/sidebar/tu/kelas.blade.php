@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs('tu.kelas.*'),
    'hasArrow' => false,
    'icon' => 'bell',
    'itemName' => 'Class & Homeroom',
    'route' => route('tu.kelas.index'),
])
