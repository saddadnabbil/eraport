@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs('tu.siswa.*'),
    'hasArrow' => false,
    'icon' => 'bell',
    'itemName' => 'Students',
    'route' => route('tu.siswa.index'),
])
