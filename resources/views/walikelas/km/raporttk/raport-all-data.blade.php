<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>{{ $title }} | {{ $kelas->nama_kelas }}</title>
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
        padding-top: 2pt;
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

    .page-break {
        page-break-after: always;
    }
</style>

<body>
    @foreach ($data_anggota_kelas as $anggota_kelas)
        <div class="raport watermarked">
            <table class="header-table" style="width: 100%; border-collapse: collapse">
                <tr>
                    <td class="no-indent left-align" style="vertical-align: middle">
                        <img src="./assets/dist/img/logo-with-text.png" alt="" width="135" height="60">
                    </td>

                    <td class="title-center">
                        <h1 class="center-align pad-179 pad-5 no-indent">
                            <span style="font-size: 12pt">GLOBAL INDONESIA SCHOOL
                            </span>
                            <br>

                            <span style="font-size: 10.5pt">
                                @if ($term->term == 1)
                                    FIRST TERM REPORT
                                @elseif($term->term == 2)
                                    SECOND TERM REPORT
                                @elseif($term->term == 3)
                                    SECOND TERM REPORT
                                @elseif($term->term == 4)
                                    THI
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

            <!-- Nilai raport -->
            <table style="border-collapse:collapse;" cellspacing="0">

                <!-- Heading table -->
                <tr style="height:14pt">
                    <td style="width:647px; border: 1px solid black" bgcolor="#999999">
                        <p class="s1" style="text-align: center; padding: 7px">AREA OF
                            LEARNING & DEVELPOPMENT</p>
                    </td>
                    <td style="width:74px;border: 1px solid black" bgcolor="#999999">
                        <p class="s1" style="text-align: center; padding: 7px">
                            Achivements</p>
                    </td>
                </tr>

                {{-- Content Table --}}
                <?php $no = 0; ?>
                <?php $no++; ?>
                @foreach ($dataTkElements as $element)
                    <tr style="height:25pt; background-color: #999999">
                        <td style="width:647px; border: 1px solid black">
                            <p class="s1" style="text-align: center; padding: 4px;">
                                {{ $element->name }}</p>
                        </td>
                        <td style="width:74px; border: 1px solid black">
                        </td>
                    </tr>
                    @foreach ($dataTkTopics->where('tk_element_id', $element->id) as $topic)
                        <tr style="height:25pt; background-color: #dfdfdf">
                            <td style="width:647px; border: 1px solid black">
                                <p class="s1" style="padding: 3px;">
                                    {{ $topic->name }}</p>
                            </td>
                            <td style="width:74px; border: 1px solid black;">
                            </td>
                        </tr>
                        @foreach ($dataTkSubtopics->where('tk_topic_id', $topic->id) as $subtopic)
                            <tr style="height:25pt">
                                <td style="width:647px; border: 1px solid black">
                                    <p class="s1" style="padding: 3px; font-style: italic;">
                                        {{ $subtopic->name }}</p>
                                </td>
                                <td style="width:74px; border: 1px solid black">
                                </td>
                            </tr>
                            @foreach ($dataTkPoints->where('tk_subtopic_id', $subtopic->id) as $point)
                                @php
                                    $achivement = $dataAchivements
                                        ->where('tk_point_id', $point->id)
                                        ->where('anggota_kelas_id', $anggota_kelas->id)
                                        ->first();
                                @endphp
                                @if ($achivement)
                                    @foreach ($dataAchivements->where('tk_point_id', $point->id)->where('anggota_kelas_id', $anggota_kelas->id) as $achivement)
                                        <tr style="height:25pt">
                                            <td style="647px;;border: 1px solid black">
                                                <p class="s2" style="padding: 3px; font-style: italic;">
                                                    {{ $point->name }}</p>
                                            </td>
                                            <td style="74px;;border: 1px solid black">
                                                <p class="s2" style="padding: 3px; text-align: center;">
                                                    {{ $achivement->achivement }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr style="height:25pt">
                                        <td style="647px;;border: 1px solid black">
                                            <p class="s2" style="padding: 3px; font-style: italic;">
                                                {{ $point->name }}
                                            </p>
                                        </td>
                                        <td style="74px;;border: 1px solid black">
                                            <p class="s2" style="padding: 3px;">

                                            </p>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach

                        @foreach ($dataTkPoints->where('tk_topic_id', $topic->id)->where('tk_subtopic_id', null) as $point)
                            @if ($point->tk_subtopic_id == null && $point->tk_topic_id == $topic->id)
                                @php
                                    $achivement = $dataAchivements
                                        ->where('tk_point_id', $point->id)
                                        ->where('anggota_kelas_id', $anggota_kelas->id)
                                        ->first();
                                @endphp
                                @if ($achivement)
                                    @foreach ($dataAchivements->where('tk_point_id', $point->id)->where('anggota_kelas_id', $anggota_kelas->id) as $achivement)
                                        <tr style="height:25pt">
                                            <td style="width:74px;border: 1px solid black">
                                                <p class="s2" style="padding: 3px;">
                                                    {{ $point->name }}</p>
                                            </td>
                                            <td style="width:74px;border: 1px solid black">
                                                <p class="s2" style="padding: 3px; text-align: center;">
                                                    {{ $achivement->achivement }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @php
                                        $achivement = $dataAchivements
                                            ->where('tk_point_id', $point->id)
                                            ->where('anggota_kelas_id', $anggota_kelas->id)
                                            ->first();
                                    @endphp
                                    @if ($achivement)
                                        @foreach ($dataAchivements->where('tk_point_id', $point->id)->where('anggota_kelas_id', $anggota_kelas->id) as $achivement)
                                            <tr style="height:25pt">
                                                <td style="width:74px;border: 1px solid black">
                                                    <p class="s2" style="padding: 3px;">
                                                        {{ $point->name }}</p>
                                                </td>
                                                <td style="width:74px;border: 1px solid black">
                                                    <p class="s2" style="padding: 3px; text-align: center;">
                                                        {{ $achivement->achivement }}</p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr style="height:25pt">
                                            <td style="width:74px;border: 1px solid black">
                                                <p class="s2" style="padding: 3px;">
                                                    {{ $point->name }}
                                                </p>
                                            </td>
                                            <td style="width:74px;border: 1px solid black">
                                                <p class="s2" style="padding: 3px;">
                                                </p>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @elseif ($point->tk_subtopic_id == $subtopic->id)
                                <tr style="height:25pt">
                                    <td style="width:74px;border: 1px solid black">
                                        <p class="s2" style="padding: 3px;">
                                            {{ $point->name }}</p>
                                    </td>
                                    <td style="width:74px;border: 1px solid black">
                                        <p class="s2" style="padding: 3px; text-align: center;">
                                            {{ $achivement->achivement }}</p>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                @endforeach

                <!-- EVENTS -->
                <tr style="height:25pt; background-color: #999999">
                    <td style="width:647px; border: 1px solid black">
                        <p class="s2" style="text-align: center; padding: 5px;">
                            EVENTS</p>
                    </td>
                    <td style="width:74px; border: 1px solid black">
                    </td>
                </tr>
                @foreach ($dataEvents as $event)
                    <tr style="height:25pt">
                        <td style="width:74px;border: 1px solid black">
                            <p class="s2" style="padding: 3px;">
                                {{ $event->name }}</p>
                        </td>
                        <td style="width:74px;border: 1px solid black">
                            @foreach ($dataAchivementEvents->where('anggota_kelas_id', $anggota_kelas->id) as $achivementEvent)
                                @if ($achivementEvent->tk_event_id == $event->id)
                                    <p class="s2" style="padding: 3px; text-align: center;">
                                        {{ $achivementEvent->achivement_event }}</p>
                                @else
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach

                <!-- ATTENDANCE -->
                <tr style="height:25pt; background-color: #999999">
                    <td style="width:647px; border: 1px solid black">
                        <p class="s2" style="text-align: center; padding: 5px;">
                            ATTENDANCE</p>
                    </td>
                    <td style="width:74px; border: 1px solid black">
                    </td>
                </tr>
                @foreach ($dataAttendance->where('anggota_kelas_id', $anggota_kelas->id) as $Attendance)
                    <tr style="height:25pt">
                        <td style="width:74px;border: 1px solid black">
                            <p class="s2" style="padding: 3px;">
                                No. of School Days</p>
                        </td>
                        <td style="width:74px;border: 1px solid black">
                            <p class="s2" style="padding: 3px; text-align: center;">
                                {{ isset($Attendance) && $Attendance->no_school_days ? $Attendance->no_school_days : '' }}
                            </p>
                        </td>
                    </tr>
                    <tr style="height:25pt">
                        <td style="width:74px;border: 1px solid black">
                            <p class="s2" style="padding: 3px;">
                                Days Attended</p>
                        </td>
                        <td style="width:74px;border: 1px solid black">
                            <p class="s2" style="padding: 3px; text-align: center;">
                                {{ isset($Attendance) && $Attendance->days_attended ? $Attendance->days_attended : '' }}
                            </p>
                        </td>
                    </tr>
                    <tr style="height:25pt">
                        <td style="width:74px;border: 1px solid black">
                            <p class="s2" style="padding: 3px; ">
                                Days Absent</p>
                        </td>
                        <td style="width:74px;border: 1px solid black">
                            <p class="s2" style="padding: 3px; text-align: center;">
                                {{ isset($Attendance) && $Attendance->days_absent ? $Attendance->days_absent : '' }}
                            </p>
                        </td>
                    </tr>
                @endforeach
            </table>

            <p>
                <br />
            </p>

            {{-- catatan walikelas --}}
            <table style="border-collapse:collapse;" cellspacing="0">
                <!-- ATTENDANCE -->
                <tr style="height:25pt; background-color: #dddddd" colspan="2">
                    <td style="width:728px; border: 1px solid black">
                        <p class="s1" style="text-align: center; padding: 5px;">
                            REMARKS</p>
                    </td>
                </tr>
                @foreach ($dataCatatanWalikelas->where('anggota_kelas_id', $anggota_kelas->id) as $CatatanWalikelas)
                    <tr style="height:25pt">
                        <td style="width:728px;border: 1px solid black">
                            <p class="s2" style="padding: 3px;">
                                {{ isset($CatatanWalikelas) && $CatatanWalikelas->catatan ? $CatatanWalikelas->catatan : '' }}
                            </p>
                        </td>
                    </tr>
                @endforeach
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
                        <p class="s6" style="padding-top: 10pt; text-align: center;">Parent's / Guardian's
                            Signature
                        </p>
                        <p class="s7"
                            style="padding-top: 48pt; text-align: center; border-bottom: 1px solid black; display: inline-block; max-width: 200px; width: 120px; margin: 0 auto; ">
                        </p>
                    </td>
                    <!-- Teacher's Section -->
                    <td style="width: 50%; text-align: center;">
                        <p class="s6" style="text-align: center;">
                            {{-- Serang, January 09, 2024<br>Homeroom Teacher --}}
                            {{ $anggota_kelas->kelas->tapel->km_tgl_raport->tempat_penerbitan }}
                            {{ $anggota_kelas->kelas->tapel->km_tgl_raport->tanggal_pembagian->isoFormat('MMMM D, Y') }}<br>Homeroom
                            Teacher
                        </p>
                        <p class="s7"
                            style="padding-top: 37pt; text-align: center; border-bottom: 1px solid black; display: inline-block; width: auto;">
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
                        <p class="s7"
                            style="padding-top: 37pt; text-align: center; border-bottom: 1px solid black; display: inline-block; width: auto;">
                            {{ $sekolah->kepala_sekolah }}</p>
                    </td>
                </tr>
            </table>

        </div>
        {{-- page break --}}
        <div class="page-break"></div>
    @endforeach

</body>

</html>
