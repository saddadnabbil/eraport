<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>{{ $title }} | {{ $siswa->nama_lengkap }} ({{ $siswa->nis }})</title>
    <link rel="icon" type="image/png" href="logo.png">
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
    h2,
    h3,
    h4,
    h5 .title {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
    }

    h1 {
        font-family: Arial, sans-serif;
        font-size: 14pt;
    }

    h5 {
        font-family: Arial, sans-serif;
        font-size: 13pt;
    }

    p {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        text-decoration: none;
        font-size: 11pt;
        margin: 0;
    }

    .body-table-identity {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        text-decoration: none;
        font-size: 9pt;
        margin: 0;
    }

    table,
    tbody {
        vertical-align: top;
        overflow: visible;
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

    .no {
        padding-top: 6pt;
        width: 3%;
    }

    .name {
        padding-top: 6pt;
        width: 30%;
    }

    .value {
        padding-top: 6pt;
        width: 67%;
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
    <div class="identitas">
        <table style="width: 100%; border-collapse: collapse;" class="watermarked">
            <!-- Header Table -->
            <table class="header-table" style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="text-align: left; vertical-align: middle; width: 60%">
                        <img src="./assets/dist/img/logo-with-text.png" alt="" width="140" height="65">
                    </td>

                    <td style="text-align: left; vertical-align: middle;">
                        <h5 class="title" style=" text-align: right; font-size: 10pt">
                            GLOBAL INDONESIA
                            @if ($siswa->kelas->id == '1')
                                SENIOR HIGH SCHOOL
                            @elseif($siswa->kelas->id == '2')
                                JUNIOR HIGH SCHOOL
                            @elseif($siswa->kelas->id == '3')
                                PRIMARY SCHOOL
                            @elseif($siswa->kelas->id == '4')
                                KINDERGARTEN
                            @elseif($siswa->kelas->id == '5')
                                PLAYGROUP
                            @endif
                        </h5>
                        <p
                            style="text-align: right; font-weight: normal; font-size: 6pt; line-height: 1.2; margin-left: 65px; vertical-align: middle">
                            {{ $alamat = str_replace('Kabupaten Serang, Banten.', '', $sekolah->alamat) }} <br> Telp.
                            {{ $sekolah->nomor_telpon }}
                        </p>
                    </td>

                </tr>
            </table>

            <h5 class="title"
                style="text-align: center; vertical-align: middle; padding-top: 15pt; text-decoration: underline;">
                STUDENT'S IDENTITY
            </h5>

            <!-- Body Table -->
            <table class="body-table-identity"
                style="width: 100%; border-collapse: collapse; margin-top: 10pt; padding: 0 20pt">
                <tr>
                    <td class="no" style="padding-top: 0">
                        1.
                    </td>
                    <td class="name" style="padding-top: 0">
                        Student's Name
                    </td>
                    <td class="value" style="padding-top: 0">
                        : {{ strtoupper($siswa->nama_lengkap) }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                        2.
                    </td>
                    <td class="name">
                        Student's Identity Number
                    </td>
                    <td class="value">
                        : {{ $siswa->nis }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                        3.
                    </td>
                    <td class="name">
                        NISN
                    </td>
                    <td class="value">
                        : {{ $siswa->nisn }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                        4.
                    </td>
                    <td class="name">
                        Place & Date of Birth
                    </td>
                    <td class="value">
                        @php
                            $timestamp = strtotime($siswa->tanggal_lahir);

                            $tanggal_lahir = date('j F Y', $timestamp);
                        @endphp
                        : {{ strtoupper($siswa->tempat_lahir) }},
                        {{ strtoupper($tanggal_lahir) }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                        5.
                    </td>
                    <td class="name">
                        Gender
                    </td>
                    <td class="value">
                        : {{ strtoupper($siswa->jenis_kelamin) }}

                    </td>
                </tr>
                <tr>
                    <td class="no">
                        6.
                    </td>
                    <td class="name">
                        Religion
                    </td>
                    <td class="value">
                        : @if ($siswa->agama == 1)
                            ISLAM
                        @elseif ($siswa->agama == 2)
                            PROTESTAN
                        @elseif ($siswa->agama == 3)
                            KATOLIK
                        @elseif ($siswa->agama == 4)
                            HINDU
                        @elseif ($siswa->agama == 5)
                            BUDHA
                        @elseif ($siswa->agama == 6)
                            KHONGHUCU
                        @elseif ($siswa->agama == 7)
                            Lainnya
                        @else
                            UNKOWN
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="no">
                        7.
                    </td>
                    <td class="name">
                        Family Birth Order
                    </td>
                    <td class="value">
                        : {{ $siswa->anak_ke }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                        8.
                    </td>
                    <td class="name">
                        Number of Siblings
                    </td>
                    <td class="value">
                        : {{ $siswa->jml_saudara_kandung }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                        9.
                    </td>
                    <td class="name">
                        Telp/Phone:
                    </td>
                    <td class="value">
                        : {{ $siswa->nomor_hp }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                        10.
                    </td>
                    <td class="name">
                        Admission in:
                    </td>
                    <td class="value">
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">a. </span>
                        Class
                    </td>
                    <td class="value">
                        : {{ strtoupper($siswa->kelas_masuk) }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">b. </span>
                        Year
                    </td>
                    <td class="value">
                        : {{ $siswa->tahun_masuk }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">a. </span>
                        Semester
                    </td>
                    <td class="value">
                        : {{ $siswa->semester_masuk }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                        11.
                    </td>
                    <td class="name">
                        Previous School
                    </td>
                    <td class="value">
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">a. </span>
                        Name
                    </td>
                    <td class="value">
                        : {{ $siswa->nama_sekolah_lama }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">b. </span>
                        Address
                    </td>
                    <td class="value">
                        : {{ $siswa->alamat_sekolah_lama }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                        12.
                    </td>
                    <td class="name">
                        Last Academic Level Achieved
                    </td>
                    <td class="value">
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">a. </span>
                        Name
                    </td>
                    <td class="value">
                        : {{ $siswa->prestasi_sekolah_lama }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">b. </span>
                        Year
                    </td>
                    <td class="value">
                        : {{ $siswa->tahun_prestasi_sekolah_lama }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">c. </span>
                        Certificate Number
                    </td>
                    <td class="value">
                        : {{ $siswa->sertifikat_number_sekolah_lama }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                        13.
                    </td>
                    <td class="name">
                        Parents
                    </td>
                    <td class="value">
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">a. </span>
                        Father
                    </td>
                    <td class="value">
                        : {{ $siswa->nama_ayah }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        Phone
                    </td>
                    <td class="value">
                        : {{ $siswa->nomor_hp_ayah }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        Occupation
                    </td>
                    <td class="value">
                        : {{ $siswa->pekerjaan_ayah }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">b. </span>
                        Mother
                    </td>
                    <td class="value">
                        : {{ $siswa->nama_ibu }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        Phone
                    </td>
                    <td class="value">
                        : {{ $siswa->nomor_hp_ibu }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        Occupation
                    </td>
                    <td class="value">
                        : {{ $siswa->pekerjaan_ibu }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">c. </span>
                        Address
                    </td>
                    <td class="value">
                        : {{ $siswa->alamat_ayah }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                        14.
                    </td>
                    <td class="name">
                        Guardian (if any)
                    </td>
                    <td class="value">
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">a. </span>
                        Name
                    </td>
                    <td class="value">
                        : {{ $siswa->nama_wali }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">b. </span>
                        Address
                    </td>
                    <td class="value">
                        : {{ $siswa->alamat_wali }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">c. </span>
                        Phone
                    </td>
                    <td class="value">
                        : {{ $siswa->nomor_hp_wali }}
                    </td>
                </tr>
                <tr>
                    <td class="no">
                    </td>
                    <td class="name">
                        <span class="no">d. </span>
                        Occupation
                    </td>
                    <td class="value">
                        : {{ $siswa->pekerjaan_wali }}
                    </td>
                </tr>
            </table>

            <!-- Footer Table -->
            <table class="footer-table"
                style="width: 100%; border-collapse: collapse; margin-top: 10pt; padding: 10 48pt 0 48pt;">
                <tr>
                    <td
                        style="text-align: left; vertical-align: middle; display: inline-block; border: 1px solid black; padding: 2pt">
                        @if (Storage::disk('public')->exists('siswa/' . $siswa->nis . '.jpg'))
                            <img class="mb-2" src="{{ asset('storage/siswa/' . $siswa->nis . '.jpg') }}"
                                alt="{{ $siswa->pas_photo }}" alt="pas_photo" width="105px">
                        @else
                            <img src="{{ asset('assets/dist/img/3x4.png') }}" alt="" id="pas_photo_preview"
                                width="105px" height="144px">
                        @endif
                    </td>
                    <td style=" text-align: center; vertical-align: middle; line-height: 1.3; padding-right: 160pt">
                        <p style="font-size: 8pt">
                            {{-- date now --}}
                            Serang, {{ date('d F Y') }}
                        </p>
                        <p style="font-size: 8pt">
                            Principal
                        </p>
                        @if (Storage::disk('public')->exists('ttd_kepala_sekolah/' . $sekolah->nip_kepala_sekolah . '.jpg'))
                            <div>
                                <img src="{{ asset('storage/ttd_kepala_sekolah/' . $sekolah->nip_kepala_sekolah . '.jpg') }}"
                                    alt="{{ $sekolah->nip_kepala_sekolah }}" width="120px"
                                    class="text-align: center; ">
                            </div>
                        @endif
                        <h5
                            style="font-size: 8pt; text-align: center; border-bottom: 0.4px solid black; display: inline-block; width: auto;">
                            {{ $sekolah->kepala_sekolah }}</h5>
                    </td>
                </tr>

            </table>
        </table>
    </div>
    <div class="page-break"></div>

</body>

</html>
