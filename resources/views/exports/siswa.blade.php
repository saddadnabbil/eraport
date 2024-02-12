<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <td colspan="9"><strong>DATA SISWA</strong></td>
            </tr>
            <tr>
                <td colspan="9">Waktu download : {{ $time_download }}</td>
            </tr>
            <tr>
                <td colspan="9">Didownload oleh : {{ Auth::user()->admin->nama_lengkap }}
                    ({{ Auth::user()->username }})</td>
            </tr>
        </thead>
        <tbody>
            <!-- siswa  -->
            <tr>
            </tr>
            <tr>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>No</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>NIS</strong>
                </td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>NISN</strong>
                </td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Status</strong>
                </td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Jenis
                        Pendaftaran</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Kelas</strong>
                </td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Full
                        name</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Nama
                        Panggilan</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>NIK</strong>
                </td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Jenis
                        Kelamin</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Golongan
                        Darah</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Agama</strong>
                </td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Tempat
                        Lahir</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Tanggal
                        Lahir</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Anak
                        Ke</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Jumlah Saudara
                        Kandung</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Warga
                        Negara</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Alamat</strong>
                </td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Kota</strong>
                </td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Kode
                        Pos</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Email</strong>
                </td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Email
                        Parent</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Nomor
                        HP</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Tinggal
                        Bersama</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Transportasi</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>NIK
                        Ayah</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Nama
                        Ayah</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Tempat Lahir
                        Ayah</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Tanggal Lahir
                        Ayah</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Alamat
                        Ayah</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Nomor HP
                        Ayah</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Agama
                        Ayah</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Kota
                        Ayah</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Pendidikan
                        Terakhir Ayah</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Pekerjaan
                        Ayah</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Penghasilan
                        Ayah</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>NIK
                        Ibu</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Nama
                        Ibu</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Tempat Lahir
                        Ibu</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Tanggal Lahir
                        Ibu</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Alamat
                        Ibu</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Nomor HP
                        Ibu</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Agama
                        Ibu</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Kota
                        Ibu</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Pendidikan
                        Terakhir Ibu</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Pekerjaan
                        Ibu</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Penghasilan
                        Ibu</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>NIK
                        Wali</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Nama
                        Wali</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Tempat Lahir
                        Wali</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Tanggal Lahir
                        Wali</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Alamat
                        Wali</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Nomor HP
                        Wali</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Agama
                        Wali</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Kota
                        Wali</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Pendidikan
                        Terakhir Wali</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Pekerjaan
                        Wali</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Penghasilan
                        Wali</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Tinggi
                        Badan</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Berat
                        Badan</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Spesial
                        Treatment</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Note
                        Kesehatan</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Tanggal Masuk
                        Sekolah Lama</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Tanggal
                        Keluar Sekolah Lama</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Nama Sekolah
                        Lama</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Prestasi
                        Sekolah Lama</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Tahun
                        Prestasi Sekolah Lama</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Sertifikat
                        Number Sekolah Lama</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Alamat
                        Sekolah Lama</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>No STTB
                        Sekolah Lama</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>NEM Sekolah
                        Lama</strong></td>
            </tr>

            <?php $no = 0; ?>
            @foreach ($data_siswa as $siswa)
                <?php $no++; ?>
                <tr>
                    {{-- information student --}}
                    <td align="center" style="border: 1px solid #000000;">{{ $no }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $siswa->nis }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $siswa->nisn }}</td>
                    <td style="border: 1px solid #000000;">
                        @if ($siswa->status == 1)
                            Aktif
                        @elseif($siswa->status == 2)
                            Keluar
                        @elseif($siswa->status == 3)
                            Lulus
                        @endif
                    </td>
                    <td style="border: 1px solid #000000;">
                        @if ($siswa->jenis_pendaftaran == 1)
                            Siswa Baru
                        @else
                            Pindahan
                        @endif
                    </td>
                    <td align="center" style="border: 1px solid #000000;">
                        @if (is_null($siswa->kelas_id))
                        @else
                            {{ $siswa->kelas->nama_kelas }}
                        @endif
                    </td>
                    <td style="border: 1px solid #000000;">{{ $siswa->nama_lengkap }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->nama_panggilan }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->nik }}</td>
                    <td style="border: 1px solid #000000;">
                        @if ($siswa->jenis_kelamin == 'MALE')
                            Male
                        @else
                            Female
                        @endif
                    </td>
                    <td style="border: 1px solid #000000;">{{ $siswa->blood_type }}</td>
                    <td style="border: 1px solid #000000;">
                        @if ($siswa->agama == 1)
                            Islam
                        @elseif($siswa->agama == 2)
                            Protestan
                        @elseif($siswa->agama == 3)
                            Katolik
                        @elseif($siswa->agama == 4)
                            Hindu
                        @elseif($siswa->agama == 5)
                            Budha
                        @elseif($siswa->agama == 6)
                            Khonghucu
                        @elseif($siswa->agama == 7)
                            Kepercayaan
                        @endif
                    </td>
                    <td style="border: 1px solid #000000;">{{ $siswa->tempat_lahir }}</td>
                    <td style="border: 1px solid #000000;">{{ date('d-m-Y', strtotime($siswa->tanggal_lahir)) }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $siswa->anak_ke }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $siswa->jml_saudara_kandung }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $siswa->warga_negara }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->alamat }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->kota }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->kode_pos }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->email }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->email_parent }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->nomor_hp }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->tinggal_bersama }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->transportasi }}</td>

                    {{-- ayah --}}
                    <td style="border: 1px solid #000000;">{{ $siswa->nik_ayah }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->nama_ayah }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->tempat_lahir_ayah }}</td>
                    <td style="border: 1px solid #000000;">{{ date('d-m-Y', strtotime($siswa->tanggal_lahir_ayah)) }}
                    </td>
                    <td style="border: 1px solid #000000;">{{ $siswa->alamat_ayah }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->nomor_hp_ayah }}</td>
                    <td style="border: 1px solid #000000;">
                        @if ($siswa->agama_ayah == 1)
                            Islam
                        @elseif($siswa->agama_ayah == 2)
                            Protestan
                        @elseif($siswa->agama_ayah == 3)
                            Katolik
                        @elseif($siswa->agama_ayah == 4)
                            Hindu
                        @elseif($siswa->agama_ayah == 5)
                            Budha
                        @elseif($siswa->agama_ayah == 6)
                            Khonghucu
                        @elseif($siswa->agama_ayah == 7)
                            Kepercayaan
                        @endif
                    </td>
                    <td style="border: 1px solid #000000;">{{ $siswa->kota_ayah }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->pendidikan_terakhir_ayah }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->pekerjaan_ayah }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->penghasil_ayah }}</td>

                    {{-- ibu --}}
                    <td style="border: 1px solid #000000;">{{ $siswa->nik_ibu }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->nama_ibu }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->tempat_lahir_ibu }}</td>
                    <td style="border: 1px solid #000000;">{{ date('d-m-Y', strtotime($siswa->tanggal_lahir_ibu)) }}
                    </td>
                    <td style="border: 1px solid #000000;">{{ $siswa->alamat_ibu }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->nomor_hp_ibu }}</td>
                    <td style="border: 1px solid #000000;">
                        @if ($siswa->agama_ibu == 1)
                            Islam
                        @elseif($siswa->agama_ibu == 2)
                            Protestan
                        @elseif($siswa->agama_ibu == 3)
                            Katolik
                        @elseif($siswa->agama_ibu == 4)
                            Hindu
                        @elseif($siswa->agama_ibu == 5)
                            Budha
                        @elseif($siswa->agama_ibu == 6)
                            Khonghucu
                        @elseif($siswa->agama_ibu == 7)
                            Kepercayaan
                        @endif
                    </td>
                    <td style="border: 1px solid #000000;">{{ $siswa->kota_ibu }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->pendidikan_terakhir_ibu }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->pekerjaan_ibu }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->penghasil_ibu }}</td>

                    {{-- wali --}}
                    <td style="border: 1px solid #000000;">{{ $siswa->nik_wali }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->nama_wali }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->tempat_lahir_wali }}</td>
                    <td style="border: 1px solid #000000;">{{ date('d-m-Y', strtotime($siswa->tanggal_lahir_wali)) }}
                    </td>
                    <td style="border: 1px solid #000000;">{{ $siswa->alamat_wali }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->nomor_hp_wali }}</td>
                    <td style="border: 1px solid #000000;">
                        @if ($siswa->agama_wali == 1)
                            Islam
                        @elseif($siswa->agama_wali == 2)
                            Protestan
                        @elseif($siswa->agama_wali == 3)
                            Katolik
                        @elseif($siswa->agama_wali == 4)
                            Hindu
                        @elseif($siswa->agama_wali == 5)
                            Budha
                        @elseif($siswa->agama_wali == 6)
                            Khonghucu
                        @elseif($siswa->agama_wali == 7)
                            Kepercayaan
                        @endif
                    </td>
                    <td style="border: 1px solid #000000;">{{ $siswa->kota_wali }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->pendidikan_terakhir_wali }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->pekerjaan_wali }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->penghasil_wali }}</td>

                    {{-- kesehatan --}}
                    <td style="border: 1px solid #000000;">{{ $siswa->tinggi_badan }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->berat_badan }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->spesial_treatment }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->note_kesehatan }}</td>


                    {{-- sekolah lama --}}
                    <td style="border: 1px solid #000000;">
                        {{ date('d-m-Y', strtotime($siswa->tanggal_masuk_sekolah_lama)) }}</td>
                    <td style="border: 1px solid #000000;">
                        {{ date('d-m-Y', strtotime($siswa->tanggal_keluar_sekolah_lama)) }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->nama_sekolah_lama }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->prestasi_sekolah_lama }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->tahun_prestasi_sekolah_lama }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->sertifikat_number_sekolah_lama }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->alamat_sekolah_lama }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->no_sttb }}</td>
                    <td style="border: 1px solid #000000;">{{ $siswa->nem }}</td>
                </tr>
            @endforeach
            <!-- End siswa  -->
        </tbody>
    </table>
</body>

</html>
