@php
    $userRole = Auth::user()->getRoleNames()->first();

    switch ($userRole) {
        case 'Admin':
            $checkRoute = request()->routeIs('tk.penilaian.*');
            $dynamicRoute = route('tk.penilaian.index');
            break;
        case 'Teacher':
            $checkRoute = request()->routeIs('guru.tk.penilaian.*');
            $dynamicRoute = route('guru.tk.penilaian.index');
            break;
        // case 'Student':
        //     $checkRoute = request()->routeIs('siswa.silabus.*');
        //     $dynamicRoute = route('siswa.silabus.index');
        //     break;
    }
@endphp

@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => $checkRoute,
    'hasArrow' => false,
    'icon' => 'clipboard',
    'itemName' => 'Penilaiaan',
    'route' => $dynamicRoute,
])
