<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $title }} | {{ $anggota_kelas->siswa->nama_lengkap }} ({{ $anggota_kelas->siswa->nis }})</title>
    <link rel="icon" type="image/png" href="./assets/dist/img/logo.png">
    <style>
        /* main */
        body {
            padding: 30px;
            font-family: Arial, sans-serif;
            color: black;
        }

        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
        }

        .w-100 {
            width: 100%
        }

        h1,
        .h2,
        h3 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
        }

        h1 {
            font-size: 15px;
        }

        h2 {
            font-size: 11px;
        }

        h3 {
            font-size: 10px;
        }

        h4 {
            font-size: 8px;
        }

        p {
            font-style: normal;
            font-size: 8px;
            line-height: 1.5;
        }

        p.deskripsi-project {
            font-size: 10px;
        }

        .header .title {
            font-size: 16px;
        }

        .header .sub-title {
            font-size: 14px;
        }

        .text-align-center {
            text-align: center;
        }

        .text-align-left {
            text-align: left;
        }

        .text-align-right {
            text-align: right;
        }

        .p-0 {
            padding: 0;
        }

        .mt-15 {
            margin-top: 15px;
        }

        .mb-15 {
            margin-bottom: 15px;
        }

        .mb-5 {
            margin-bottom: 5px;
        }

        .watermarked {
            position: relative;
        }

        .watermarked:after {
            content: "";
            display: block;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0px;
            left: 0px;
            background-image: url("{{ public_path() . '/assets/dist/img/logo.png' }}");
            background-size: 40%;
            background-position: center center;
            background-repeat: no-repeat;
            opacity: 0.1;
        }

        @media print {
            td {
                -webkit-print-color-adjust: exact;
                /* For Chrome */
                print-color-adjust: exact;
                /* For other browsers */
            }
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #333;
            padding: 10px 0;
            background-color: #f9f9f9;
            border-top: 1px solid #ccc;
        }

        .pentunjuk-penilaian th,
        .pentunjuk-penilaian td {
            text-align: left;
            width: 70%;
        }

        table.cell-border,
        table.cell-border th,
        table.cell-border td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 3px;
        }
    </style>
</head>

<body>
    <div class="raport watermarked">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td>
                    <img src="./assets/dist/img/logo-with-text.png" alt="" width="135" height="60">
                </td>

                <td>
                    <h1 class="text-align-center header">
                        <span class="title">GLOBAL INDONESIA SCHOOL
                        </span>
                        <br>

                        <span class="sub-title">
                            RAPOR PROJEK PENGUATAN PROFIL PELAJAR PANCASILA
                            <br>
                            {{ str_replace('-', ' / ', $anggota_kelas->kelas->tapel->tahun_pelajaran) }}
                        </span>
                    </h1>
                    <p class="text-align-center pad-126 line-height-123" style="padding: 0 60pt">
                        Address : {{ $sekolah->alamat }} Phone: {{ $sekolah->nomor_telpon }}
                    </p>
                </td>

                <td>
                    <img src="{{ public_path() . '/assets/dist/img/tut-wuri-handayani.png' }}" alt=""
                        width="80px" height="80px">
                </td>
            </tr>
        </table>

        <!-- information name -->
        <table class="w-100">
            <tr>
                <td style="width: 6%">
                    <h3>Name</h3>
                </td>
                <td style="width: 64%">
                    <h3>: {{ $anggota_kelas->siswa->nama_lengkap }}</h3>
                </td>
                <td style="width: 12%">
                    <h3>Homeroom</h3>
                </td>
                <td style="width: 24%">
                    <h3>: {{ $anggota_kelas->kelas->nama_kelas }}</h3>
                </td>
            </tr>
            <tr>
                <td style="width: 6%">
                    <h3>NISN</h3>
                </td>
                <td style="width: 73%">
                    <h3>: {{ $anggota_kelas->siswa->nisn }}</h3>
                </td>
                <td style="width: 19%">
                    <h3>Homeroom Teacher</h3>
                </td>
                <td style="width: 19%">
                    <h3>: {{ $anggota_kelas->kelas->guru->karyawan->nama_lengkap }}</h3>
                </td>
            </tr>
        </table>

        <div style="margin: 15px 2px">
            @foreach ($dataProject as $key => $project)
                <div class="mb-5">
                    <h3>Projek {{ $key + 1 }} | {{ $project->name }}</h3>
                    <p class="deskripsi-project">
                        {{ $project->description }}
                    </p>
                </div>
            @endforeach
        </div>

        <table class="pentunjuk-penilaian" style="padding: 0; margin: 15px 0px">
            <tr>
                <th>
                    <h3>BB. Belum Berkembang</h3>
                </th>
                <th>
                    <h3>MB. Mulai Berkembang</h3>
                </th>
                <th>
                    <h3>BSH. Berkembang Sesuai Harapan</h3>
                </th>
                <th>
                    <h3>SB. Sangat Berkembang</h3>
                </th>
            </tr>
            <tr>
                <td>
                    <p style="line-height: 1.2" class="deskripsi-project">Siswa masih membutuhkan bimbingan dalam
                        mengembangkan kemampuan</p>
                </td>
                <td>
                    <p style="line-height: 1.2" class="deskripsi-project">Siswa mulai mengembangkan kemampuan namun
                        masih belum ajek</p>
                </td>
                <td>
                    <p style="line-height: 1.2" class="deskripsi-project">Siswa telah mengembangkan kemampuan hingga
                        berada dalam tahap ajek</p>
                </td>
                <td>
                    <p style="line-height: 1.2" class="deskripsi-project">Siswa mengembangkan kemampuannya melampaui
                        harapan</p>
                </td>
            </tr>
        </table>

        @foreach ($dataProject as $key => $project)
            <h2 style="margin: 5px 0 0 2px;">{{ $key + 1 }}. {{ $project->name }}</h2>
            <table class="w-100" style="border-top: none">
                <tr>
                    <td style="width: 60%; border: none; text-align:center;"></td>
                    <td style="width: 10%; border: none; text-align:center;">
                        <h4>BB</h4>
                    </td>
                    <td style="width: 10%; border: none; text-align:center;">
                        <h4>MB</h4>
                    </td>
                    <td style="width: 10%; border: none; text-align:center;">
                        <h4>BSH</h4>
                    </td>
                    <td style="width: 10%; border: none; text-align:center;">
                        <h4>SB</h4>
                    </td>
                </tr>
            </table>
            <table class="w-100 cell-border mb-15" style="border-top: none">
                @php $prevDimension = null; @endphp
                @foreach ($project->active_subelement as $no => $subelement)
                    @if ($subelement->dimensi_name !== $prevDimension)
                        <tr>
                            <td colspan="5" style="background-color: #f0f0f0">
                                <h4>{{ $subelement->dimensi_name }}</h4>
                            </td>
                        </tr>
                        @php $prevDimension = $subelement->dimensi_name; @endphp
                    @endif
                    <tr>
                        <td style="width: 60%;">
                            <ul style="margin: 0; padding-left: 16px; list-style: none;">
                                <li style="list-style-type: disc; font-size: 10px;">
                                    <h4>{{ $subelement->name }}</h4>
                                    <p style="line-height: 1.2">{{ $subelement->description }}</p>
                                </li>
                            </ul>
                        </td>
                        @foreach (['BB', 'MB', 'BSH', 'SB'] as $grade)
                            <td style="width: 10%; text-align: center">
                                @foreach ($dataNilaiProject as $nilai)
                                    @if ($project->id == $nilai->p5_project_id)
                                        @php $gradeData = json_decode($nilai->grade_data); @endphp
                                        @foreach ($gradeData as $data)
                                            @if ($data->subelement_id == $subelement->id && $data->grade == $grade)
                                                <div style="font-family: DejaVu Sans, sans-serif;">✔</div>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                @foreach ($dataNilaiProject as $nilai)
                    @if ($project->id == $nilai->p5_project_id)
                        <tr>
                            <td colspan="5">
                                <h4>Catatan Proses</h4>
                                <p>
                                    {{ $nilai->catatan_proses }}
                                </p>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
        @endforeach

        <!-- Signature Table -->
        <table class="signature" style="width: 100%;">
            <!-- Top Section -->
            <tr>
                <!-- Parent's Section -->
                <td style="width: 50%; text-align: center;">
                    <p class="s6" style="padding-top: 10pt; text-align: center;">Parent's / Guardian's Signature
                    </p>
                    <p class="s7"
                        style="padding-top: 48pt; text-align: center; border-bottom: 1px solid black; display: inline-block; max-width: 200px; width: 120px; margin: 0 auto; ">
                    </p>
                </td>
                <!-- Teacher's Section -->
                <td style="width: 50%; text-align: center;">
                    <p class="s6" style="text-align: center;">

                        @php
                            $timestamp = strtotime($anggota_kelas->kelas->tapel->km_tgl_raport->tanggal_pembagian);

                            $tanggal_lahir = date('j F Y', $timestamp);
                        @endphp
                        {{ $anggota_kelas->kelas->tapel->km_tgl_raport->tempat_penerbitan }},
                        {{ \Carbon\Carbon::parse($anggota_kelas->kelas->tapel->tk_tgl_raport->tanggal_penerbitan)->format('d F Y') }}<br>Homeroom
                        Teacher
                    </p>
                    @if (Storage::disk('public')->exists('ttd/' . $anggota_kelas->kelas->guru->karyawan->kode_karyawan . '.jpg'))
                        <div>
                            <img src="{{ asset('storage/ttd/' . $anggota_kelas->kelas->guru->karyawan->kode_karyawan . '.jpg') }}"
                                alt="{{ $anggota_kelas->kelas->guru->karyawan->kode_karyawan }}" width="120px"
                                class="text-align: center; ">
                        </div>
                    @endif
                    <p class="s7"
                        style="text-align: center; border-bottom: 1px solid black; display: inline-block; width: auto;">
                        @if ($anggota_kelas->kelas->guru)
                            {{ $anggota_kelas->kelas->guru->karyawan->nama_lengkap }}
                            {{ $anggota_kelas->kelas->guru->gelar }}
                        @else
                            Guru not available
                        @endif
                    </p>
                </td>
            </tr>
            <!-- Bottom Section -->
            <tr>
                <td colspan="2" style="text-align: center; margin-top: 15px;">
                    <p class="s6" style="padding-top: 6pt; text-align: center;">Principal's Signature</p>
                    @if (Storage::disk('public')->exists('ttd_kepala_sekolah/' . $sekolah->nip_kepala_sekolah . '.jpg'))
                        <div>
                            <img src="{{ asset('storage/ttd_kepala_sekolah/' . $sekolah->nip_kepala_sekolah . '.jpg') }}"
                                alt="{{ $sekolah->nip_kepala_sekolah }}" width="120px" class="text-align: center; ">
                        </div>
                    @endif
                    <p class="s7"
                        style="text-align: center; border-bottom: 1px solid black; display: inline-block; width: auto;">
                        {{ $sekolah->kepala_sekolah }}</p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
