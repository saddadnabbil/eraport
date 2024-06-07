<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>{{ $title }} | {{ $anggota_kelas->siswa->nama_lengkap }} ({{ $anggota_kelas->siswa->nis }})</title>
    <link rel="icon" type="image/png" href="./assets/dist/img/logo.png">
</head>

<style>
    /* main */
    body {
        padding: 30px;
    }

    * {
        margin: 0;
        padding: 0;
        text-indent: 0;
    }

    h1,
    .h2,
    h3,
    .s1 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
    }

    h1 {
        font-size: 11pt;
    }

    .h2 {
        font-size: 10pt;
    }

    p {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        text-decoration: none;
        font-size: 6pt;
        margin: 0;
    }

    h3,
    .s1,
    .s2,
    .s4,
    .s6,
    .s7 {
        font-size: 8pt;
    }

    .s3 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: italic;
        font-weight: normal;
        text-decoration: none;
        font-size: 6pt;
    }

    .s5 {
        font-size: 7pt;
    }

    table,
    tbody {
        vertical-align: top;
        overflow: visible;
    }


    .center-align {
        text-align: center;
    }

    .left-align {
        text-align: left;
    }

    .right-align {
        text-align: right;
    }

    .no-indent {
        text-indent: 0pt;
    }

    .pad-179 {
        padding: 0 20pt;
    }

    .pad-5 {
        padding-top: 5pt;
    }

    .pad-2-1 {
        padding-top: 3pt;
        padding-bottom: 1pt;
    }

    .line-height-123 {
        line-height: 123%;
    }

    .information-container {
        width: 100%;
        border-collapse: collapse;
    }

    /* table  */
    /* 1 */
    .border-collapse {
        border-collapse: collapse;
    }

    .h-14 {
        height: 14pt;
    }

    .cell-style {
        border-top-style: solid;
        border-top-width: 1pt;
        border-left-style: solid;
        border-left-width: 1pt;
        border-bottom-style: solid;
        border-bottom-width: 1pt;
        border-right-style: solid;
        border-right-width: 1pt;
    }

    .w-17 {
        width: 17pt;
    }

    .bg-grey {
        background-color: #999999;
    }

    .s1 {
        text-indent: 0pt;
    }

    .left-text {
        text-align: left;
    }

    .pt-2 {
        padding-top: 2pt;
    }

    .pt-3 {
        padding-top: 3pt;
    }

    .pt-7 {
        padding-top: 7pt;
    }

    .pl-75 {
        padding-left: 75pt;
    }

    /* 2 */

    h-25 {
        height: 25pt;
    }

    p.s2 {
        text-indent: 0pt;
    }

    p.s3 {
        text-indent: 0pt;
    }

    p.s2-right {
        text-align: right;
        padding-right: 2pt;
    }

    p.s2-left {
        text-align: left;
        padding-left: 2pt;
    }

    p.s2-center {
        text-align: center;
        padding-left: 1pt;
    }

    p.status-good {
        text-align: center;
        padding-left: 1pt;
    }

    /* .bottom-table {
        display: flex;
    } */

    .signature-top {
        display: flex;
        justify-content: space-between;
    }

    .teacher {
        text-align: center;
    }

    .signature-top {
        display: flex;
        justify-content: space-between;
    }

    /* Mengatur tampilan parent */
    .parent {
        text-align: left;
    }

    /* Mengatur tampilan teacher */
    .teacher {
        text-align: right;
    }

    /* Mengatur tampilan signature bottom */
    .signature-bottom {
        margin-top: 10px;
        /* Atur margin atas sesuai kebutuhan */
        text-align: center;
        /* Mengatur agar konten berada di tengah */
    }

    .signature-bottom .s7 {
        display: inline-block;
        /* Mengatur agar elemen berada dalam satu baris */
        max-width: 200px;
        /* Atur lebar maksimum sesuai kebutuhan */
        border-bottom: 1px solid black;
        /* Menambahkan garis bawah */
        text-align: center;
        /* Mengatur agar konten berada di tengah */
        margin: 0 auto;
        /* Mengatur margin otomatis untuk mengatur posisi tengah */
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
</style>

<body>
    <div class="raport watermarked">
        <table class="header-table" style="width: 100%; border-collapse: collapse">
            <tr>
                <td class="no-indent left-align" style="vertical-align: middle">
                    <img src="./assets/dist/img/logo-with-text.png" alt="" width="135" height="60">
                </td>

                <td class="title-center">
                    <h1 class="center-align pad-179 pad-5 no-indent">
                        <span style="font-size: 12pt">
                            GLOBAL INDONESIA
                            @if ($anggota_kelas->kelas->tingkatan_id == '6')
                                SENIOR HIGH SCHOOL
                            @elseif($anggota_kelas->kelas->tingkatan_id == '5')
                                JUNIOR HIGH SCHOOL
                            @elseif($anggota_kelas->kelas->tingkatan_id == '4')
                                PRIMARY SCHOOL
                            @elseif($anggota_kelas->kelas->tingkatan_id == '2' || $anggota_kelas->kelas->tingkatan_id == '3')
                                KINDERGARTEN
                            @elseif($anggota_kelas->kelas->tingkatan_id == '1')
                                PLAYGROUP
                            @endif
                        </span>
                        <br>

                        <span style="font-size: 10.5pt">
                            @if ($semester->id == 1)
                                FIRST SEMESTER PROGRESS REPORT
                            @else
                                YEAR END REPORT
                            @endif
                        </span>
                        <br>
                        {{ str_replace('-', ' / ', $anggota_kelas->kelas->tapel->tahun_pelajaran) }}
                    </h1>
                    <p class="center-align pad-126 line-height-123" style="padding: 0 60pt">
                        Address : {{ $sekolah->alamat }} Phone: {{ $sekolah->nomor_telpon }}
                    </p>
                </td>

                <td class="no-indent right-align">
                    <img src="{{ public_path() . '/assets/dist/img/tut-wuri-handayani.png' }}" alt=""
                        width="80px" height="80px">
                </td>
            </tr>
        </table>

        <!-- information name -->
        <table class="information-container pad-2-1"">
            <tr>
                <td style="width: 6%">
                    <h3>Name</h3>
                </td>
                <td style="width: 64%">
                    <h3>: {{ $anggota_kelas->siswa->nama_lengkap }}</h3>
                </td>
                <td style="width: 6%">
                    <h3>Class</h3>
                </td>
                <td style="width: 24%">
                    <h3>: {{ $anggota_kelas->kelas->nama_kelas }}</h3>
                </td>
            </tr>
            <tr>
                <td style="width: 6%">
                    <h3>NIS</h3>
                </td>
                <td style="width: 69%">
                    <h3>: {{ $anggota_kelas->siswa->nis }} </h3>
                </td>
                <td style="width: 6%">
                    <h3>NISN</h3>
                </td>
                <td style="width: 19%">
                    <h3>: {{ $anggota_kelas->siswa->nisn }}</h3>
                </td>
            </tr>
        </table>

        <!-- Nilai raport -->
        <table style="border-collapse:collapse;" cellspacing="0">

            <!-- Heading table -->
            <tr style="height:14pt">
                <td style="width:17pt;border: 1px solid black;" bgcolor="#999999">
                    <p style="text-indent: 0pt;text-align: left;">
                        <br />
                    </p>
                    <p class="s1" style="padding-left: 3pt;text-indent: 0pt;text-align: left;">No</p>
                    <p style="text-indent: 0pt;text-align: left;">
                        <br />
                    </p>
                </td>
                <td style="width:181pt;border: 1px solid black;" bgcolor="#999999">
                    <p style="text-indent: 0pt;text-align: left;">
                        <br />
                    </p>
                    <p class="s1"
                        style="padding-left: 61pt;padding-right: 61pt;text-indent: 0pt;text-align: center;">Subject</p>
                </td>
                <td style="width:56pt;border: 1px solid black;" bgcolor="#999999">
                    <p class="s1" style="padding-top: 2pt;padding-left: 1pt;text-indent: 0pt;text-align: center;">
                        Minimum Passing Mark</p>
                </td>
                <td style="width:48pt;border: 1px solid black;" bgcolor="#999999">
                    <p class="s1"
                        style="padding-top: 2pt;padding-left: 13pt; padding-right: 13pt;text-align: center;">Final Grade
                    </p>
                </td>
                <td style="width:48pt;border: 1px solid black;" bgcolor="#999999">
                    <p class="s1" style="padding-top: 6pt;text-align: center;">Grade</p>
                </td>
                <td style="width:187pt;border: 1px solid black;" bgcolor="#999999">
                    <p class="s1" style="padding-top: 6pt;text-align: center;">Capaian Pembelajaran</p>
                </td>
            </tr>

            {{-- Content Table --}}
            <?php $no = 0; ?>
            @foreach ($data_nilai_akhir_total as $nilai)
                <?php $no++; ?>
                <tr style="height:25pt">
                    <td style="width:17pt;border: 1px solid black;">
                        <p class="s2"
                            style="padding-top: 7pt;padding-right: 2pt;text-indent: 0pt;text-align: center;">
                            {{ $no }}</p>
                    </td>
                    <td style="width:181pt;border: 1px solid black;">
                        <p class="s2" style="padding-top: 3pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">
                            {{ $nilai['nama_mapel'] }}</p>
                        <p class="s3"
                            style="padding-top: 2pt;padding-left: 2pt;text-indent: 0pt;text-align: left; padding-bottom: 3pt">
                            {{ $nilai['nama_mapel_indonesian'] }}</p>
                    </td>
                    <td style="width:48pt;border: 1px solid black;">
                        <p class="s2"
                            style="padding-top: 7pt;padding-left: 1pt;text-indent: 0pt;text-align: center;">
                            {{ $nilai['kkm'] }}</p>
                    </td>
                    <td style="width:48pt;border: 1px solid black;">
                        <p class="s2"
                            style="padding-top: 7pt;padding-left: 1pt;text-indent: 0pt;text-align: center;">
                            {{ $semester->id == 1 ? $nilai['nilai_akhir_semester_1'] : $nilai['nilai_akhir_total'] }}
                        </p>
                    </td>
                    <td style="width:48pt;border: 1px solid black;">
                        <p class="s2"
                            style="padding-top: 7pt;padding-left: 1pt;text-indent: 0pt;text-align: center;">
                            {{ $nilai['predikat'] }}</p>
                    </td>
                    <td style="width:187px;border: 1px solid black;">
                        <p class="s2"
                            style="padding-top: 7pt;padding-bottom: 7pt;padding-left: 4pt; padding-right: 3pt;text-indent: 0pt; line-height: 1.3;">
                            {!! !is_null($nilai['deskripsi_nilai']) ? nl2br($nilai['deskripsi_nilai']->deskripsi_raport) : '' !!}
                        </p>
                    </td>

                </tr>
            @endforeach

        </table>

        <p>
            <br />
        </p>

        <!-- Extracurricular -->
        <table style="border-collapse:collapse;" cellspacing="0">
            <tr style="height:14pt">
                <td style="width:17pt;border: 1px solid black;" bgcolor="#CCCCCC">
                    <p class="s1"
                        style="padding-top: 1pt;padding-left: 2pt;padding-right: 1pt;text-indent: 0pt;text-align: center;padding-bottom: 1pt">
                        No</p>
                </td>
                <td style="width:181pt;border: 1px solid black;" bgcolor="#CCCCCC">
                    <p class="s1"
                        style="padding-top: 1pt;padding-left: 61pt;padding-right: 61pt;text-indent: 0pt;text-align: center; padding-bottom: 1pt">
                        Extracurricular</p>
                </td>
                <td style="width:57pt;border: 1px solid black;" bgcolor="#CCCCCC">
                    <p class="s1"
                        style="padding-top: 1pt;padding-left: 1pt;text-indent: 0pt;text-align: center; padding-bottom: 1pt">
                        Grade</p>
                </td>
                <td style="width:284pt;border: 1px solid black;" bgcolor="#CCCCCC">
                    <p class="s1"
                        style="padding-top: 1pt;padding-left: 100pt;padding-right: 99pt;text-indent: 0pt;text-align: center;padding-bottom: 1pt">
                        Remarks</p>
                </td>
            </tr>
            @if (count($data_anggota_ekstrakulikuler) == 0)
                <tr style="height:12pt">
                    <td style="width:17pt;border: 1px solid black;">
                        <p class="s5"
                            style="padding-top: 1pt;text-indent: 0pt;text-align: center;padding-bottom: 1pt">-</p>
                    </td>
                    <td style="width:181pt;border: 1px solid black;">
                        <p class="s5"
                            style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;padding-bottom: 1pt; text-align: center">
                            -</p>
                    </td>
                    <td style="width:57pt;border: 1px solid black;">
                        <p class="s5"
                            style="padding-top: 1pt;text-indent: 0pt;text-align: center;padding-bottom: 1pt; text-align: center">
                            -</p>
                    </td>
                    <td style="width:284pt;border: 1px solid black;">
                        <p class="s5"
                            style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;padding-bottom: 1pt; text-align: center">
                            -</p>
                    </td>
                </tr>
            @else
                <?php $no = 0; ?>
                @foreach ($data_anggota_ekstrakulikuler as $nilai_ekstra)
                    <?php $no++; ?>
                    <tr style="height:12pt">
                        <td style="width:17pt;border: 1px solid black;">
                            <p class="s5"
                                style="padding-top: 1pt;text-indent: 0pt;text-align: center; padding-bottom: 1pt">
                                {{ $no }}</p>
                        </td>
                        <td style="width:181pt;border: 1px solid black;">
                            <p class="s5"
                                style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left; padding-bottom: 1pt">
                                {{ $nilai_ekstra->ekstrakulikuler->nama_ekstrakulikuler }}</p>
                        </td>
                        <td style="width:57pt;border: 1px solid black;">
                            <p class="s5"
                                style="padding-top: 1pt;text-indent: 0pt;text-align: center; padding-bottom: 1pt">
                                {{ $nilai_ekstra->nilai }}</p>
                        </td>
                        <td style="width:284pt;border: 1px solid black;">
                            <p class="s5"
                                style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left; padding-bottom: 1pt">
                                {!! nl2br($nilai_ekstra->deskripsi) !!}</p>
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>

        <p>
            <br />
        </p>

        <!-- Achievement -->
        <table style="border-collapse:collapse;" cellspacing="0">
            <tr style="height:14pt">
                <td style="width:17pt;border: 1px solid black;" bgcolor="#CCCCCC">
                    <p class="s1"
                        style="padding: 1pt 0;padding-left: 2pt;padding-right: 1pt;text-indent: 0pt;text-align: center;">
                        No</p>
                </td>
                <td style="width:181pt;border: 1px solid black;" bgcolor="#CCCCCC">
                    <p class="s1"
                        style="padding: 1pt 0;padding-left: 61pt;padding-right: 61pt;text-indent: 0pt;text-align: center;">
                        Achievement</p>
                </td>
                <td style="width:57pt;border: 1px solid black;" bgcolor="#CCCCCC">
                    <p class="s1" style="padding: 1pt 0;padding-left: 1pt;text-indent: 0pt;text-align: center;">
                        Level</p>
                </td>
                <td style="width:284pt;border: 1px solid black;" bgcolor="#CCCCCC">
                    <p class="s1"
                        style="padding: 1pt 0;padding-left: 100pt;padding-right: 99pt;text-indent: 0pt;text-align: center;">
                        Name of Competition</p>
                </td>
            </tr>
            @if (count($data_prestasi_siswa) == 0)
                <tr style="height:12pt">
                    <td style="width:17pt;border: 1px solid black;">
                        <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">-</p>
                    </td>
                    <td style="width:181pt;border: 1px solid black;">
                        <p class="s5"
                            style="padding: 1pt 0;padding-left: 2pt;text-indent: 0pt;text-align: center;">
                            -</p>
                    </td>
                    <td style="width:57pt;border: 1px solid black;">
                        <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">-</p>
                    </td>
                    <td style="width:284pt;border: 1px solid black;">
                        <p class="s5"
                            style="padding: 1pt 0;padding-left: 2pt;text-indent: 0pt;text-align: center;">
                            -</p>
                    </td>
                </tr>
            @else
                <?php $no = 0; ?>
                @foreach ($data_prestasi_siswa as $prestasi)
                    <?php $no++; ?>
                    <tr style="height:12pt">
                        <td style="width:17pt;border: 1px solid black;">
                            <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">
                                {{ $no }}</p>
                        </td>
                        <td style="width:181pt;border: 1px solid black;">
                            <p class="s5"
                                style="padding: 1pt 0;padding-left: 2pt;text-indent: 0pt;text-align: left;">
                                {{ $prestasi->nama_prestasi }}</p>
                            </p>
                        </td>
                        <td style="width:57pt;border: 1px solid black;">
                            <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">
                                @if ($prestasi->tingkat_prestasi == 1)
                                    Internations
                                @elseif($prestasi->tingkat_prestasi == 2)
                                    National
                                @elseif($prestasi->tingkat_prestasi == 3)
                                    Province
                                @elseif($prestasi->tingkat_prestasi == 4)
                                    City
                                @elseif($prestasi->tingkat_prestasi == 5)
                                    District
                                @elseif($prestasi->tingkat_prestasi == 6)
                                    Inter School
                                @endif
                            </p>
                        </td>
                        <td style="width:284pt;border: 1px solid black;">
                            <p class="s5"
                                style="padding: 1pt 0;padding-left: 2pt;text-indent: 0pt;text-align: left;">
                                {!! nl2br($prestasi->deskripsi) !!}</p>
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>

        <p>
            <br />
        </p>

        <!-- Container Table -->
        <table class="container-table" style="width: 100%; border-collapse:collapse;">
            <tr>
                <!-- Absences Table -->
                <td style="vertical-align: top;">
                    <!-- Absences Scale -->
                    <table style="border-collapse:collapse;" cellspacing="0">
                        <tr style="height:14pt">
                            <td style="width:190pt;border: 1px solid black;" colspan="2" bgcolor="#CCCCCC">
                                <p class="s1" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">Absences
                                </p>
                            </td>
                            <td style="width:50pt;border: 1px solid black;" bgcolor="#CCCCCC">
                                <p class="s1" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">Days</p>
                            </td>
                        </tr>
                        @if (!is_null($kehadiran_siswa))
                            <tr style="height:12pt">
                                <td style="width:17pt;border: 1px solid black;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">1
                                    </p>
                                </td>
                                <td style="width:178pt;border: 1px solid black;">
                                    <p class="s5"
                                        style="padding: 1pt 0;padding-left: 2pt;text-indent: 0pt;text-align: left;">
                                        Sick</p>
                                </td>
                                <td style="width:57pt;border: 1px solid black;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">
                                        {{ $kehadiran_siswa->sakit }}</p>
                                </td>
                            </tr>
                            <tr style="height:12pt">
                                <td style="width:17pt;border: 1px solid black;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">2
                                    </p>
                                </td>
                                <td style="width:178pt;border: 1px solid black;">
                                    <p class="s5"
                                        style="padding: 1pt 0;padding-left: 2pt;text-indent: 0pt;text-align: left;">
                                        Permit</p>
                                </td>
                                <td style="width:57pt;border: 1px solid black;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">
                                        {{ $kehadiran_siswa->izin }}</p>
                                </td>
                            </tr>
                            <tr style="height:12pt">
                                <td style="width:17pt;border: 1px solid black;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">3
                                    </p>
                                </td>
                                <td style="width:178pt;border: 1px solid black;">
                                    <p class="s5"
                                        style="padding: 1pt 0;padding-left: 2pt;text-indent: 0pt;text-align: left;">
                                        Without Permission</p>
                                </td>
                                <td style="width:57pt;border: 1px solid black;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">
                                        {{ $kehadiran_siswa->tanpa_keterangan }}</p>
                                </td>
                            </tr>
                            <tr style="height:12pt">
                                <td style="width:17pt;border: 1px solid black;">
                                    <p style="text-indent: 0pt;text-align: left;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;"><br>
                                    </p>
                                    </p>
                                </td>
                                <td style="width:178pt;border: 1px solid black;">
                                    <p style="text-indent: 0pt;text-align: left;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;"><br>
                                    </p>
                                    </p>
                                </td>
                                <td style="width:57pt;border: 1px solid black;">
                                    <p style="text-indent: 0pt;text-align: left;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;"><br>
                                    </p>
                                    </p>
                                </td>
                            </tr>
                        @else
                            <tr style="height:12pt">
                                <td style="width:17pt;border: 1px solid black;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">1
                                    </p>
                                </td>
                                <td style="width:178pt;border: 1px solid black;">
                                    <p class="s5"
                                        style="padding: 1pt 0;padding-left: 2pt;text-indent: 0pt;text-align: left;">
                                        Sick</p>
                                </td>
                                <td style="width:57pt;border: 1px solid black;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">0
                                    </p>
                                </td>
                            </tr>
                            <tr style="height:12pt">
                                <td style="width:17pt;border: 1px solid black;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">2
                                    </p>
                                </td>
                                <td style="width:178pt;border: 1px solid black;">
                                    <p class="s5"
                                        style="padding: 1pt 0;padding-left: 2pt;text-indent: 0pt;text-align: left;">
                                        Permit</p>
                                </td>
                                <td style="width:57pt;border: 1px solid black;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">0
                                    </p>
                                </td>
                            </tr>
                            <tr style="height:12pt">
                                <td style="width:17pt;border: 1px solid black;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">3
                                    </p>
                                </td>
                                <td style="width:178pt;border: 1px solid black;">
                                    <p class="s5"
                                        style="padding: 1pt 0;padding-left: 2pt;text-indent: 0pt;text-align: left;">
                                        Without Permission</p>
                                </td>
                                <td style="width:57pt;border: 1px solid black;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">0
                                    </p>
                                </td>
                            </tr>
                            <tr style="height:12pt">
                                <td style="width:17pt;border: 1px solid black;">
                                    <p style="text-indent: 0pt;text-align: left;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;"><br>
                                    </p>
                                    </p>
                                </td>
                                <td style="width:178pt;border: 1px solid black;">
                                    <p style="text-indent: 0pt;text-align: left;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;"><br>
                                    </p>
                                    </p>
                                </td>
                                <td style="width:57pt;border: 1px solid black;">
                                    <p style="text-indent: 0pt;text-align: left;">
                                    <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;"><br>
                                    </p>
                                    </p>
                                </td>
                            </tr>
                        @endif
                    </table>
                </td>
                <!-- Grading Scale Table -->
                <td style="vertical-align: top;">
                    <!-- Grading Scale -->
                    <table style="border-collapse:collapse; padding-right: 10px" cellspacing="0">
                        <tr style="height:14pt">
                            <td style="width:278pt;border: 1px solid black;" colspan="3" bgcolor="#CCCCCC">
                                <p class="s1" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">Grading
                                    Scale</p>
                            </td>
                        </tr>
                        <tr style="height:12pt">
                            <td style="width:57pt;border: 1px solid black;">
                                <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">A</p>
                            </td>
                            <td style="width:85pt;border: 1px solid black;">
                                <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">80.00 -
                                    100.00</p>
                            </td>
                            <td style="width:136pt;border: 1px solid black;">
                                <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">
                                    Excellent</p>
                            </td>
                        </tr>
                        <tr style="height:12pt">
                            <td style="width:57pt;border: 1px solid black;">
                                <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">B</p>
                            </td>
                            <td style="width:85pt;border: 1px solid black;">
                                <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">70.00 -
                                    79.99</p>
                            </td>
                            <td style="width:136pt;border: 1px solid black;">
                                <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">Good</p>
                            </td>
                        </tr>
                        <tr style="height:12pt">
                            <td style="width:57pt;border: 1px solid black;">
                                <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">C</p>
                            </td>
                            <td style="width:85pt;border: 1px solid black;">
                                <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">60.00 -
                                    69.99</p>
                            </td>
                            <td style="width:136pt;border: 1px solid black;">
                                <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">Fair</p>
                            </td>
                        </tr>
                        <tr style="height:12pt">
                            <td style="width:57pt;border: 1px solid black;">
                                <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">D</p>
                            </td>
                            <td style="width:85pt;border: 1px solid black;">
                                <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">0.00 -
                                    59.99</p>
                            </td>
                            <td style="width:136pt;border: 1px solid black;">
                                <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">Need
                                    Improvement</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <p>
            <br />
        </p>

        <!-- Homeroom Teacher's Comments -->
        <table style="border-collapse:collapse; " cellspacing="0">
            <tr style="height:14pt">
                <td style="width:722px;border: 1px solid black;" colspan="3" bgcolor="#CCCCCC">
                    <p class="s1"
                        style="padding: 1pt 0;padding-left: 110pt;padding-right: 110pt;text-indent: 0pt;text-align: center;">
                        Homeroom Teacher&#39;s Comments</p>
                </td>
            </tr>
            <tr style="height:14pt">
                <td style="width:278pt;border: 1px solid black;" colspan="3">
                    @if (!is_null($catatan_wali_kelas))
                        <p class="s5"
                            style="padding: 1pt 0;text-indent: 0pt;text-align: left; padding-left: 2pt;">
                            {{ $catatan_wali_kelas->catatan }}
                        </p>
                    @else
                        <p class="s5"
                            style="padding: 1pt 0;text-indent: 0pt;text-align: left; padding-left: 2pt; text-align: center">
                            -
                        </p>
                    @endif
                </td>
            </tr>
        </table>

        <p>
            <br />
        </p>

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
                        {{ \Carbon\Carbon::parse($anggota_kelas->kelas->tapel->km_tgl_raport->tanggal_penerbitan)->format('d F Y') }}<br>Homeroom
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
                                alt="{{ $sekolah->nip_kepala_sekolah }}" width="120px"
                                class="text-align: center; ">
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
