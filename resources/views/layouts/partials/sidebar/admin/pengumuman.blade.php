@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs('pengumuman.*'),
    'hasArrow' => false,
    'icon' => 'bell',
    'itemName' => 'Announcement',
    'route' => route('pengumuman.index'),
])