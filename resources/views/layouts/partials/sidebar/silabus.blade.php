@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs('admin.silabus.*'),
    'hasArrow' => false,
    'icon' => 'plus-circle',
    'itemName' => 'Silabus',
    'route' => route('admin.silabus.index'),
])
