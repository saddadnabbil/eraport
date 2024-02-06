@include('layouts.partials.sidebar._sidebar-item', [
    'isActive' => request()->routeIs(['sekolah.*', 'guru.*', 'siswa.*', 'tingkatan.*', 'jurusan.*', 'tapel.*', 'mapel.*', 'kkm.*', 'kelas.*', 'pembelajaran.*', 'ekstrakulikuler.*', 'admin.silabus.*']),
    'hasArrow' => true,
    'icon' => 'database',
    'itemName' => 'Master Data',
    'route' => 'javascript:void(0)',
    'subItems' => [
        [
            'name' => 'School Profile',
            'route' => route('sekolah.index'),
            'isActive' => request()->routeIs('sekolah.*'),
        ],
        [
            'name' => 'Academic Year',
            'route' => route('tapel.index'),
            'isActive' => request()->routeIs('tapel.*'),
        ],
        [
            'name' => 'Students',
            'route' => route('siswa.index'),
            'isActive' => request()->routeIs('siswa.*'),
        ],
        // [
        //     'name' => 'Teachers',
        //     'route' => route('guru.index'),
        //     'isActive' => request()->routeIs('guru.*'),
        // ],
        [
            'name' => 'Level',
            'route' => route('tingkatan.index'),
            'isActive' => request()->routeIs('tingkatan.*'),
        ],
        [
            'name' => 'Line',
            'route' => route('jurusan.index'),
            'isActive' => request()->routeIs('jurusan.*'),
        ],
        [
            'name' => 'Subjects',
            'route' => route('mapel.index'),
            'isActive' => request()->routeIs('mapel.*'),
        ],
        [
            'name' => 'Class & Homeroom',
            'route' => route('kelas.index'),
            'isActive' => request()->routeIs('kelas.*'),
        ],
        [
            'name' => 'Learning Data',
            'route' => route('pembelajaran.index'),
            'isActive' => request()->routeIs('pembelajaran.*'),
        ],
        [
            'name' => 'Extracurricular',
            'route' => route('ekstrakulikuler.index'),
            'isActive' => request()->routeIs('ekstrakulikuler.*'),
        ],
        [
            'name' => 'Syllabus',
            'route' => route('admin.silabus.index'),
            'isActive' => request()->routeIs('admin.silabus.*'),
        ],
    ],
])