@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs('tu.pengumuman.*'),
    'hasArrow' => false,
    'icon' => 'bell',
    'itemName' => 'Announcement',
    'route' => route('tu.pengumuman.index'),
])
