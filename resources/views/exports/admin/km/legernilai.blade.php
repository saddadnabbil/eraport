<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leger K13 {{ $kelas->nama_kelas }}</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <td colspan="9"><strong>LEGER NILAI SISWA KELAS {{ $kelas->nama_kelas }}</strong></td>
            </tr>
            <tr>
                <td colspan="9"><strong>{{ $sekolah->nama_sekolah }}</strong></td>
            </tr>
            <tr>
                <td colspan="9"><strong>Academic Year {{ $kelas->tapel->tahun_pelajaran }} SEMESTER
                        {{ $kelas->tapel->semester_id }}</strong></td>
            </tr>
            <tr>
                <td colspan="9">Waktu download : {{ $time_download }}</td>
            </tr>
            <tr>
                <td colspan="9">Didownload oleh : {{ Auth::user()->karyawan->nama_lengkap }}
                    ({{ Auth::user()->username }})</td>
            </tr>
        </thead>
        <tbody>
            <!-- siswa  -->
            <tr>
            </tr>
            <!-- Header -->

            <tr>
                <td rowspan="2" align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>NO</strong></td>
                <td rowspan="2" align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>NIS</strong></td>
                <td rowspan="2" align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>NAMA SISWA</strong></td>

                @foreach ($data_mapel_kelompok_a->sortBy('pembelajaran.mapel.km_mapping_mapel.nomor_urut') as $mapel_kelompok_a)
                    <td colspan="4" align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                        <strong>{{ $mapel_kelompok_a->pembelajaran->mapel->nama_mapel }}</strong></td>
                @endforeach

                @foreach ($data_mapel_kelompok_b->sortBy('pembelajaran.mapel.km_mapping_mapel.nomor_urut') as $mapel_kelompok_b)
                    <td colspan="4" align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                        <strong>{{ $mapel_kelompok_b->pembelajaran->mapel->nama_mapel }}</strong></td>
                @endforeach

                <td colspan="2" align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Rata-Rata</strong></td>
                <td colspan="3" align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Kehadiran</strong></td>
                <td colspan="{{ $count_ekstrakulikuler }}" align="center"
                    style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Ekstrakulikuler</strong></td>
            </tr>

            <tr>
                @foreach ($data_mapel_kelompok_a->sortBy('pembelajaran.mapel.km_mapping_mapel.nomor_urut') as $mapel_kelompok_a)
                    <td align="center" colspan="2" style="border: 1px solid #000000; background-color: #d9ecd0;">
                        <strong>Sumatif</strong></td>
                    <td align="center" colspan="2" style="border: 1px solid #000000; background-color: #d9ecd0;">
                        <strong>Formatif</strong></td>
                @endforeach

                @foreach ($data_mapel_kelompok_b->sortBy('pembelajaran.mapel.km_mapping_mapel.nomor_urut') as $mapel_kelompok_b)
                    <td align="center" colspan="2" style="border: 1px solid #000000; background-color: #d9ecd0;">
                        <strong>Sumatif</strong></td>
                    <td align="center" colspan="2" style="border: 1px solid #000000; background-color: #d9ecd0;">
                        <strong>Formatif</strong></td>
                @endforeach

                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Sumatif</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Formatif</strong></td>

                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>S</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>I</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>A</strong></td>
                @foreach ($data_ekstrakulikuler->sortBy('id') as $ekstrakulikuler)
                    <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                        <strong>{{ $ekstrakulikuler->nama_ekstrakulikuler }}</strong></td>
                @endforeach
            </tr>
            <!-- /Header -->

            <!-- Data  -->
            <?php $no = 0; ?>
            @foreach ($data_anggota_kelas->sortBy('siswa.nama_lengkap') as $anggota_kelas)
                <?php $no++; ?>
                <tr>
                    <td align="center" style="border: 1px solid #000000;">{{ $no }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $anggota_kelas->siswa->nis }}</td>
                    <td style="border: 1px solid #000000;">{{ $anggota_kelas->siswa->nama_lengkap }}</td>

                    @foreach ($anggota_kelas->data_nilai_kelompok_a->sortBy('pembelajaran.mapel.km_mapping_mapel.nomor_urut') as $nilai_kelompok_a)
                        <td align="center" style="border: 1px solid #000000;">{{ $nilai_kelompok_a->nilai_sumatif }}
                        </td>
                        <td align="center" style="border: 1px solid #000000;">{{ $nilai_kelompok_a->predikat_sumatif }}
                        </td>
                        <td align="center" style="border: 1px solid #000000;">{{ $nilai_kelompok_a->nilai_formatif }}
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            {{ $nilai_kelompok_a->predikat_formatif }}</td>
                    @endforeach

                    @foreach ($anggota_kelas->data_nilai_kelompok_b->sortBy('pembelajaran.mapel.km_mapping_mapel.nomor_urut') as $nilai_kelompok_b)
                        <td align="center" style="border: 1px solid #000000;">{{ $nilai_kelompok_b->nilai_sumatif }}
                        </td>
                        <td align="center" style="border: 1px solid #000000;">{{ $nilai_kelompok_b->predikat_sumatif }}
                        </td>
                        <td align="center" style="border: 1px solid #000000;">{{ $nilai_kelompok_b->nilai_formatif }}
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            {{ $nilai_kelompok_b->predikat_formatif }}</td>
                    @endforeach

                    <td align="center" style="border: 1px solid #000000;">{{ $anggota_kelas->rata_rata_sumatif }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $anggota_kelas->rata_rata_formatif }}</td>

                    @if (!is_null($anggota_kelas->kehadiran_siswa))
                        <td align="center" style="border: 1px solid #000000;">
                            {{ $anggota_kelas->kehadiran_siswa->sakit }}</td>
                        <td align="center" style="border: 1px solid #000000;">
                            {{ $anggota_kelas->kehadiran_siswa->izin }}</td>
                        <td align="center" style="border: 1px solid #000000;">
                            {{ $anggota_kelas->kehadiran_siswa->tanpa_keterangan }}</td>
                    @else
                        <td align="center" style="border: 1px solid #000000;">-</td>
                        <td align="center" style="border: 1px solid #000000;">-</td>
                        <td align="center" style="border: 1px solid #000000;">-</td>
                    @endif

                    @foreach ($anggota_kelas->data_nilai_ekstrakulikuler as $nilai_ekstrakulikuler)
                        @if ($nilai_ekstrakulikuler->nilai == 1)
                            <td align="center" style="border: 1px solid #000000;">Kurang</td>
                        @elseif($nilai_ekstrakulikuler->nilai == 2)
                            <td align="center" style="border: 1px solid #000000;">Cukup</td>
                        @elseif($nilai_ekstrakulikuler->nilai == 3)
                            <td align="center" style="border: 1px solid #000000;">Baik</td>
                        @elseif($nilai_ekstrakulikuler->nilai == 4)
                            <td align="center" style="border: 1px solid #000000;">Sangat Baik</td>
                        @else
                            <td align="center" style="border: 1px solid #000000;">-</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
            <!-- End Data  -->
        </tbody>
    </table>
</body>

</html>
