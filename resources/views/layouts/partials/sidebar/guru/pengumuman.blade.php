@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs('guru.pengumuman.*'),
    'hasArrow' => false,
    'icon' => 'bell',
    'itemName' => 'Announcement',
    'route' => route('guru.pengumuman.index'),
])
