@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs('tu.mapel.*'),
    'hasArrow' => false,
    'icon' => 'bell',
    'itemName' => 'Subjects',
    'route' => route('tu.mapel.index'),
])
