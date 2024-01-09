<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <title>{{$title}} | {{$anggota_kelas->siswa->nama_lengkap}} ({{$anggota_kelas->siswa->nis}})</title>
  <link href="./assets/invoice_raport.css" rel="stylesheet">
</head>

<body>
  <!-- Page 1 Sikap -->
  {{-- <div class="invoice-box">
    <div class="header">
      <table>
        <tr>
          <td style="width: 19%;">Nama Sekolah</td>
          <td style="width: 52%;">: {{$sekolah->nama_sekolah}}</td>
          <td style="width: 16%;">Kelas</td>
          <td style="width: 13%;">: {{$anggota_kelas->kelas->nama_kelas}}</td>
        </tr>
        <tr>
          <td style="width: 19%;">Alamat</td>
          <td style="width: 52%;">: {{$sekolah->alamat}}</td>
          <td style="width: 16%;">Semester</td>
          <td style="width: 13%;">:
          
            @if($anggota_kelas->kelas->tapel->semester->semester == 1)
            1 (Ganjil)
            @else
            2 (Genap)
            @endif
          </td>
        </tr>
        <tr>
          <td style="width: 19%;">Nama Peserta Didik</td>
          <td style="width: 52%;">: {{$anggota_kelas->siswa->nama_lengkap}} </td>
          <td style="width: 16%;">Tahun Pelajaran</td>
          <td style="width: 13%;">: {{$anggota_kelas->kelas->tapel->tahun_pelajaran}}</td>
        </tr>
        <tr>
          <td style="width: 19%;">Nomor Induk/NISN</td>
          <td style="width: 52%;">: {{$anggota_kelas->siswa->nis}} / {{$anggota_kelas->siswa->nisn}} </td>
        </tr>
      </table>
    </div>

    <div class="content">
      <h3><strong>PENCAPAIAN KOMPETENSI PESERTA DIDIK</strong></h3>
      <table cellspacing="0">
        <tr>
          <td colspan="2"><strong>A. SIKAP</strong></td>
        </tr>

        <tr>
          <td colspan="2" style="height: 30px;"><strong>1. Sikap Spiritual</strong></td>
        </tr>
        <tr class="heading">
          <td style="width: 20%;">Predikat</td>
          <td>Deskripsi</td>
        </tr>
        <tr class="sikap">
          @if(!is_null($deskripsi_sikap))
          <td class="predikat">
            @if($deskripsi_sikap->nilai_spiritual == 4)
            <b>Sangat Baik</b>
            @elseif($deskripsi_sikap->nilai_spiritual == 3)
            <b>Baik</b>
            @elseif($deskripsi_sikap->nilai_spiritual == 2)
            <b>Cukup</b>
            @elseif($deskripsi_sikap->nilai_spiritual == 1)
            <b>Kurang</b>
            @endif
          </td>
          <td class="description">
            <span>{!! nl2br($deskripsi_sikap->deskripsi_spiritual) !!}</span>
          </td>
          @else
          <td></td>
          <td></td>
          @endif
        </tr>

        <tr>
          <td colspan="2" style="height: 30px;"><strong>2. Sikap Sosial</strong></td>
        </tr>
        <tr class="heading">
          <td style="width: 20%;">Predikat</td>
          <td>Deskripsi</td>
        </tr>
        <tr class="sikap">
          @if(!is_null($deskripsi_sikap))
          <td class="predikat">
            @if($deskripsi_sikap->nilai_sosial == 4)
            <b>Sangat Baik</b>
            @elseif($deskripsi_sikap->nilai_sosial == 3)
            <b>Baik</b>
            @elseif($deskripsi_sikap->nilai_sosial == 2)
            <b>Cukup</b>
            @elseif($deskripsi_sikap->nilai_sosial == 1)
            <b>Kurang</b>
            @endif
          </td>
          <td class="description">
            <span>{!! nl2br($deskripsi_sikap->deskripsi_sosial) !!}</span>
          </td>
          @else
          <td></td>
          <td></td>
          @endif
        </tr>
      </table>
    </div>

    <div style="padding-left:60%; padding-top:1rem; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
      {{$anggota_kelas->kelas->tapel->km_tgl_raport->tempat_penerbitan}}, {{$anggota_kelas->kelas->tapel->km_tgl_raport->tanggal_pembagian->isoFormat('D MMMM Y')}}<br>
      Wali Kelas, <br><br><br><br>
      <b><u>{{$anggota_kelas->kelas->guru->nama_lengkap}}, {{$anggota_kelas->kelas->guru->gelar}}</u></b><br>
      NIP. {{konversi_nip($anggota_kelas->kelas->guru->nip)}}
    </div>
    <div class="footer">
      <i>{{$anggota_kelas->kelas->nama_kelas}} | {{$anggota_kelas->siswa->nama_lengkap}} | {{$anggota_kelas->siswa->nis}}</i> <b style="float: right;"><i>Halaman 1</i></b>
    </div>
  </div> --}}

  {{-- <div id="kop-surat-1" style="display: block;" class="">
    <table style="width: 100%;!important;table-layout: fixed;">
        <colgroup>
            <col style="width: 95px;">
            <col>
            <col style="width: 95px;">
        </colgroup>
        <tbody>
            <tr>
                <td rowspan="6">
                    <div id="img-kiri">
                        <img id="logo_kiri_pada_kop" src="https://storage.googleapis.com/rapor_merdeka_media_bucket/section/12/logo_tutwuri.png" alt="" height="95px" width="95px">
                    </div>
                </td>
                <td class="desc-kop-surat" id="desc-kop-surat-1" style=" font-weight: bold; font-size:  18px; color:#000000; text-align: center;">PEMERINTAH PROVINSI SUMATERA UTARA</td>
                <td rowspan="6">
                    <div id="img-kanan">
                        <img id="logo_kanan_pada_kop" src="https://storage.googleapis.com/rapor_merdeka_media_bucket/section/12/DWAF.png" alt="" height="95px" width="95px">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="desc-kop-surat" id="desc-kop-surat-2" style="  font-weight: bold; font-size:  18px; color:#000000; text-align: center;">D I N A S   P E N D I D I K A N</td>
            </tr>
            <tr>
                <td class="desc-kop-surat" id="desc-kop-surat-3" style="  font-weight: bold; font-size:  16px; color:#000000; text-align: center;">SMA NEGERI 1 LAHUSA</td>
            </tr>
            <tr>
                <td class="desc-kop-surat" id="desc-kop-surat-4" style=" font-size:  12px; color:#000000; text-align: center;">Alamat : Desa Hilindrasoniha Kecamatan Toma Kabupaten Nias Selatan Kode Pos: 22865</td>
            </tr>
            <tr>
                <td class="desc-kop-surat" id="desc-kop-surat-5" style=" font-size:  12px; color:#000000; text-align: center;">Email : sman2toma@gmail.com Akreditas : B</td>
            </tr>
            <tr>
                <td class="desc-kop-surat" id="desc-kop-surat-6" style=" font-size:  9px; color:#000000; text-align: center;"></td>
            </tr>
        </tbody>
    </table>
    <hr id="garis-bawah-kop" style="background-color: black !important;color: black;height:1.0px;opacity:1;">
  </div>
  <table class="table-anak">
          <tbody>
              <tr>
                  <td style="width:15%">Nama </td>
                  <td style="width:5%">:</td>
                  <td style="width:42%">Budi Sudiyatno</td>
                  <td style="width:17%">Kelas</td>
                  <td style="width:5%">:</td>
                  <td style="width:15%">7 A</td>
              </tr>
              <tr>
                  <td style="width:15%">NIS / NISN</td>
                  <td style="width:5%">:</td>
                  <td style="width:42%">0000001 / 000292192</td>
                  <td style="width:17%">Fase</td>
                      <td style="width:5%">:</td>
                      <td style="width:20%">D</td>
              </tr>
              <tr>
                  <td style="width:15%">Nama Sekolah</td>
                  <td style="width:5%">:</td>
                  <td style="width:42%">SMP MAJU JAYA</td>
                  <td style="width:17%">Semester</td>
                      <td style="width:5%">:</td>
                      <td style="width:15%">2022/2023</td>
              </tr>
              <tr>
                  <td style="width:15%">Alamat</td>
                  <td style="width:5%">:</td>
                  <td style="width:42%">Jl. Maju Tidak Gentar</td>
                  <td style="width:17%">Tahun Pelajaran</td>
                      <td style="width:5%">:</td>
                      <td style="width:15%">2022</td>
              </tr>
              <tr>
                  <td colspan="6">
                      <hr style="opacity: 1;">
                  </td>
              </tr>
          </tbody>
  </table>
  <div class="page-break"></div> --}}


  <!-- Page 2 sumatif  -->
  <div class="invoice-box">
    <div class="header">
      <table>
        <tr>
          <td style="width: 19%;">Nama Sekolah</td>
          <td style="width: 52%;">: {{$sekolah->nama_sekolah}}</td>
          <td style="width: 16%;">Kelas</td>
          <td style="width: 13%;">: {{$anggota_kelas->kelas->nama_kelas}}</td>
        </tr>
        <tr>
          <td style="width: 19%;">Alamat</td>
          <td style="width: 52%;">: {{$sekolah->alamat}}</td>
          <td style="width: 16%;">Semester</td>
          <td style="width: 13%;">:
            @if($anggota_kelas->kelas->tapel->semester->semester == 1)
            1 (Ganjil)
            @else
            2 (Genap)
            @endif
          </td>
        </tr>
        <tr>
          <td style="width: 19%;">Nama Peserta Didik</td>
          <td style="width: 52%;">: {{$anggota_kelas->siswa->nama_lengkap}} </td>
          <td style="width: 16%;">Tahun Pelajaran</td>
          <td style="width: 13%;">: {{$anggota_kelas->kelas->tapel->tahun_pelajaran}}</td>
        </tr>
        <tr>
          <td style="width: 19%;">Nomor Induk/NISN</td>
          <td style="width: 52%;">: {{$anggota_kelas->siswa->nis}} / {{$anggota_kelas->siswa->nisn}} </td>
        </tr>
      </table>
    </div>

    <div class="content">
      <h3><strong>PENCAPAIAN KOMPETENSI PESERTA DIDIK</strong></h3>
      <table cellspacing="0">
        <tr>
          <td colspan="6" style="height: 30px;"><strong>A. PENGETAHUAN DAN KETERAMPILAN</strong></td>
        </tr>
        <tr class="heading">
          <td rowspan="2" style="width: 5%;">NO</td>
          <td rowspan="2" style="width: 23%;">Mata Pelajaran</td>
          <td rowspan="2" style="width: 7%;">KKM</td>
          <td colspan="3">Pengetahuan</td>
        </tr>
        <tr class="heading">
          <td style="width: 6%;">Nilai</td>
          <td style="width: 7%;">Predikat</td>
          <td>Capaian Pembelajaran</td>
        </tr>
        <!-- Nilai A  -->
        <tr class="nilai">
          <td colspan="6"><strong>Kelompok A</strong></td>
        </tr>

        <?php $no = 0; ?>
        @foreach($data_nilai_kelompok_a->sortBy('pembelajaran.mapel.km_mapping_mapel.nomor_urut') as $nilai_kelompok_a)
        <?php $no++; ?>
        <tr class="nilai">
          <td class="center">{{$no}}</td>
          <td>{{$nilai_kelompok_a->pembelajaran->mapel->nama_mapel}}</td>
          <td class="center">{{$nilai_kelompok_a->kkm}}</td>
          <td class="center">{{$nilai_kelompok_a->nilai_sumatif}}</td>
          <td class="center">{{$nilai_kelompok_a->predikat_sumatif}}</td>
          <td class="description">
            <span>
              {{-- @if ($nilai_kelompok_a->km_deskripsi_nilai_siswa->deskripsi_raport)
                  {!! nl2br($nilai_kelompok_a->km_deskripsi_nilai_siswa->deskripsi_raport) !!}
              @endif   --}}
            </span>
          </td>
        </tr>
        @endforeach

        <!-- Nilai B  -->
        <tr class="nilai">
          <td colspan="6"><strong>Kelompok B</strong></td>
        </tr>
        <?php $no = 0; ?>
        @foreach($data_nilai_kelompok_b->sortBy('pembelajaran.mapel.km_mapping_mapel.nomor_urut') as $nilai_kelompok_b)
        <?php $no++; ?>
        <tr class="nilai">
          <td class="center">{{$no}}</td>
          <td>{{$nilai_kelompok_b->pembelajaran->mapel->nama_mapel}}</td>
          <td class="center">{{$nilai_kelompok_b->kkm}}</td>
          <td class="center">{{$nilai_kelompok_b->nilai_sumatif}}</td>
          <td class="center">{{$nilai_kelompok_b->predikat_sumatif}}</td>
          <td class="description">
            <span>
              {{-- @if ($nilai_kelompok_b->km_deskripsi_nilai_siswa)
                  {!! nl2br($nilai_kelompok_b->km_deskripsi_nilai_siswa->deskripsi_raport) !!}
              @endif --}}
            </span>
          </td>
        </tr>
        @endforeach

      </table>
    </div>

    <div style="padding-left:60%; padding-top:1rem; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
      {{$anggota_kelas->kelas->tapel->km_tgl_raport->tempat_penerbitan}}, {{$anggota_kelas->kelas->tapel->km_tgl_raport->tanggal_pembagian->isoFormat('D MMMM Y')}}<br>
      Wali Kelas, <br><br><br><br>
      <b><u>{{$anggota_kelas->kelas->guru->nama_lengkap}}, {{$anggota_kelas->kelas->guru->gelar}}</u></b><br>
      NIP. {{konversi_nip($anggota_kelas->kelas->guru->nip)}}
    </div>
    <div class="footer">
      <i>{{$anggota_kelas->kelas->nama_kelas}} | {{$anggota_kelas->siswa->nama_lengkap}} | {{$anggota_kelas->siswa->nis}}</i> <b style="float: right;"><i>Halaman 2</i></b>
    </div>
  </div>
  <div class="page-break"></div>

  <!-- Page 3 Keterampilan -->
  <div class="invoice-box">
    <div class="header">
      <table>
        <tr>
          <td style="width: 19%;">Nama Sekolah</td>
          <td style="width: 52%;">: {{$sekolah->nama_sekolah}}</td>
          <td style="width: 16%;">Kelas</td>
          <td style="width: 13%;">: {{$anggota_kelas->kelas->nama_kelas}}</td>
        </tr>
        <tr>
          <td style="width: 19%;">Alamat</td>
          <td style="width: 52%;">: {{$sekolah->alamat}}</td>
          <td style="width: 16%;">Semester</td>
          <td style="width: 13%;">:
            @if($anggota_kelas->kelas->tapel->semester->semester == 1)
            1 (Ganjil)
            @else
            2 (Genap)
            @endif
          </td>
        </tr>
        <tr>
          <td style="width: 19%;">Nama Peserta Didik</td>
          <td style="width: 52%;">: {{$anggota_kelas->siswa->nama_lengkap}} </td>
          <td style="width: 16%;">Tahun Pelajaran</td>
          <td style="width: 13%;">: {{$anggota_kelas->kelas->tapel->tahun_pelajaran}}</td>
        </tr>
        <tr>
          <td style="width: 19%;">Nomor Induk/NISN</td>
          <td style="width: 52%;">: {{$anggota_kelas->siswa->nis}} / {{$anggota_kelas->siswa->nisn}} </td>
        </tr>
      </table>
    </div>

    <div class="content">
      <table cellspacing="0" style="padding-top: 10px;">
        <tr class="heading">
          <td rowspan="2" style="width: 5%;">NO</td>
          <td rowspan="2" style="width: 23%;">Mata Pelajaran</td>
          <td rowspan="2" style="width: 7%;">KKM</td>
          <td colspan="3">Keterampilan</td>
        </tr>
        <tr class="heading">
          <td style="width: 6%;">Nilai</td>
          <td style="width: 7%;">Predikat</td>
          <td>Deskripsi</td>
        </tr>
        <!-- Nilai A  -->
        <tr class="nilai">
          <td colspan="6"><strong>Kelompok A</strong></td>
        </tr>

        <?php $no = 0; ?>
        @foreach($data_nilai_kelompok_a->sortBy('pembelajaran.mapel.km_mapping_mapel.nomor_urut') as $nilai_kelompok_a)
        <?php $no++; ?>
        <tr class="nilai">
          <td class="center">{{$no}}</td>
          <td>{{$nilai_kelompok_a->pembelajaran->mapel->nama_mapel}}</td>
          <td class="center">{{$nilai_kelompok_a->kkm}}</td>
          <td class="center">{{$nilai_kelompok_a->nilai_formatif}}</td>
          <td class="center">{{$nilai_kelompok_a->predikat_formatif}}</td>
          <td class="description">
            {{-- <span>{!! nl2br($nilai_kelompok_a->km_deskripsi_nilai_siswa->deskripsi_raport) !!}</span> --}}
          </td>
        </tr>
        @endforeach

        <!-- Nilai B  -->
        <tr class="nilai">
          <td colspan="6"><strong>Kelompok B</strong></td>
        </tr>
        <?php $no = 0; ?>
        @foreach($data_nilai_kelompok_b->sortBy('pembelajaran.mapel.km_mapping_mapel.nomor_urut') as $nilai_kelompok_b)
        <?php $no++; ?>
        <tr class="nilai">
          <td class="center">{{$no}}</td>
          <td>{{$nilai_kelompok_b->pembelajaran->mapel->nama_mapel}}</td>
          <td class="center">{{$nilai_kelompok_b->kkm}}</td>
          <td class="center">{{$nilai_kelompok_b->nilai_formatif}}</td>
          <td class="center">{{$nilai_kelompok_b->predikat_formatif}}</td>
          <td class="description">
            {{-- <span>{!! nl2br($nilai_kelompok_b->km_deskripsi_nilai_siswa->deskripsi_raport) !!}</span> --}}
          </td>
        </tr>
        @endforeach

      </table>
    </div>

    <div style="padding-left:60%; padding-top:1rem; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
      {{$anggota_kelas->kelas->tapel->km_tgl_raport->tempat_penerbitan}}, {{$anggota_kelas->kelas->tapel->km_tgl_raport->tanggal_pembagian->isoFormat('D MMMM Y')}}<br>
      Wali Kelas, <br><br><br><br>
      <b><u>{{$anggota_kelas->kelas->guru->nama_lengkap}}, {{$anggota_kelas->kelas->guru->gelar}}</u></b><br>
      NIP. {{konversi_nip($anggota_kelas->kelas->guru->nip)}}
    </div>
    <div class="footer">
      <i>{{$anggota_kelas->kelas->nama_kelas}} | {{$anggota_kelas->siswa->nama_lengkap}} | {{$anggota_kelas->siswa->nis}}</i> <b style="float: right;"><i>Halaman 3</i></b>
    </div>
  </div>
  <div class="page-break"></div>

  <!-- Page 4 (Other) -->
  <div class="invoice-box">
    <div class="header">
      <table>
        <tr>
          <td style="width: 19%;">Nama Sekolah</td>
          <td style="width: 52%;">: {{$sekolah->nama_sekolah}}</td>
          <td style="width: 16%;">Kelas</td>
          <td style="width: 13%;">: {{$anggota_kelas->kelas->nama_kelas}}</td>
        </tr>
        <tr>
          <td style="width: 19%;">Alamat</td>
          <td style="width: 52%;">: {{$sekolah->alamat}}</td>
          <td style="width: 16%;">Semester</td>
          <td style="width: 13%;">:
            @if($anggota_kelas->kelas->tapel->semester->semester == 1)
            1 (Ganjil)
            @else
            2 (Genap)
            @endif
          </td>
        </tr>
        <tr>
          <td style="width: 19%;">Nama Peserta Didik</td>
          <td style="width: 52%;">: {{$anggota_kelas->siswa->nama_lengkap}} </td>
          <td style="width: 16%;">Tahun Pelajaran</td>
          <td style="width: 13%;">: {{$anggota_kelas->kelas->tapel->tahun_pelajaran}}</td>
        </tr>
        <tr>
          <td style="width: 19%;">Nomor Induk/NISN</td>
          <td style="width: 52%;">: {{$anggota_kelas->siswa->nis}} / {{$anggota_kelas->siswa->nisn}} </td>
        </tr>
      </table>
    </div>

    <div class="content">
      <table cellspacing="0">

        <!-- EkstraKulikuler  -->
        <tr>
          <td colspan="4" style="height: 25px;"><strong>C. EKSTRAKULIKULER</strong></td>
        </tr>
        <tr class="heading">
          <td style="width: 5%;">NO</td>
          <td style="width: 28%;">Kegiatan Ekstrakulikuler</td>
          <td style="width: 15%;">Predikat</td>
          <td>Keterangan</td>
        </tr>

        @if(count($data_anggota_ekstrakulikuler) == 0)
        <tr class="nilai">
          <td class="center">1</td>
          <td></td>
          <td class="center"></td>
          <td class="description">
            <span></span>
          </td>
        </tr>
        <tr class="nilai">
          <td class="center">2</td>
          <td></td>
          <td class="center"></td>
          <td class="description">
            <span></span>
          </td>
        </tr>
        @elseif(count($data_anggota_ekstrakulikuler) == 1)
        <?php $no = 0; ?>
        @foreach($data_anggota_ekstrakulikuler as $nilai_ekstra)
        <?php $no++; ?>
        <tr class="nilai">
          <td class="center">{{$no}}</td>
          <td>{{$nilai_ekstra->ekstrakulikuler->nama_ekstrakulikuler}}</td>
          <td class="center">
            @if($nilai_ekstra->nilai == 4)
            Sangat Baik
            @elseif($nilai_ekstra->nilai == 3)
            Baik
            @elseif($nilai_ekstra->nilai == 2)
            Cukup
            @elseif($nilai_ekstra->nilai == 1)
            Kurang
            @endif
          </td>
          <td class="description">
            <span>{!! nl2br($nilai_ekstra->deskripsi) !!}</span>
          </td>
        </tr>
        @endforeach
        <tr class="nilai">
          <td class="center">2</td>
          <td></td>
          <td class="center"></td>
          <td class="description">
            <span></span>
          </td>
        </tr>
        @else
        <?php $no = 0; ?>
        @foreach($data_anggota_ekstrakulikuler as $nilai_ekstra)
        <?php $no++; ?>
        <tr class="nilai">
          <td class="center">{{$no}}</td>
          <td>{{$nilai_ekstra->ekstrakulikuler->nama_ekstrakulikuler}}</td>
          <td class="center">
            @if($nilai_ekstra->nilai == 4)
            Sangat Baik
            @elseif($nilai_ekstra->nilai == 3)
            Baik
            @elseif($nilai_ekstra->nilai == 2)
            Cukup
            @elseif($nilai_ekstra->nilai == 1)
            Kurang
            @endif
          </td>
          <td class="description">
            <span>{!! nl2br($nilai_ekstra->deskripsi) !!}</span>
          </td>
        </tr>
        @endforeach
        @endif
        <!-- End Ekstrakulikuler  -->

        <!-- Prestasi -->
        <tr>
          <td colspan="4" style="height: 25px; padding-top: 5px"><strong>D. PRESTASI</strong></td>
        </tr>
        <tr class="heading">
          <td style="width: 5%;">NO</td>
          <td style="width: 28%;">Jenis Prestasi</td>
          <td colspan="2">Keterangan</td>
        </tr>
        @if(count($data_prestasi_siswa) == 0)
        <tr class="nilai">
          <td class="center">1</td>
          <td></td>
          <td colspan="2" class="description">
            <span></span>
          </td>
        </tr>
        <tr class="nilai">
          <td class="center">2</td>
          <td></td>
          <td colspan="2" class="description">
            <span></span>
          </td>
        </tr>
        @elseif(count($data_prestasi_siswa) == 1)
        <?php $no = 0; ?>
        @foreach($data_prestasi_siswa as $prestasi)
        <?php $no++; ?>
        <tr class="nilai">
          <td class="center">{{$no}}</td>
          <td>
            @if($prestasi->jenis_prestasi == 1)
            Akademik
            @elseif($prestasi->jenis_prestasi == 2)
            Non Akademik
            @endif
          </td>
          <td colspan="2" class="description">
            <span>{!! nl2br($prestasi->deskripsi) !!}</span>
          </td>
        </tr>
        @endforeach
        <tr class="nilai">
          <td class="center">2</td>
          <td></td>
          <td colspan="2" class="description">
            <span></span>
          </td>
        </tr>
        @else
        <?php $no = 0; ?>
        @foreach($data_prestasi_siswa as $prestasi)
        <?php $no++; ?>
        <tr class="nilai">
          <td class="center">{{$no}}</td>
          <td>
            @if($prestasi->jenis_prestasi == 1)
            Akademik
            @elseif($prestasi->jenis_prestasi == 2)
            Non Akademik
            @endif
          </td>
          <td colspan="2" class="description">
            <span>{!! nl2br($prestasi->deskripsi) !!}</span>
          </td>
        </tr>
        @endforeach
        @endif
        <!-- End Prestasi -->

        <!-- Ketidakhadiran  -->
        <tr>
          <td colspan="4" style="height: 25px; padding-top: 5px"><strong>E. KETIDAKHADIRAN</strong></td>
        </tr>
        @if(!is_null($kehadiran_siswa))
        <tr class="nilai">
          <td colspan="2" style="border-right:0 ;">Sakit</td>
          <td style="border-left:0 ;">: {{$kehadiran_siswa->sakit}} hari</td>
          <td class="false"></td>
        </tr>
        <tr class="nilai">
          <td colspan="2" style="border-right:0 ;">Izin</td>
          <td style="border-left:0 ;">: {{$kehadiran_siswa->izin}} hari</td>
          <td class="false"></td>
        </tr>
        <tr class="nilai">
          <td colspan="2" style="border-right:0 ;">Tanpa Keterangan</td>
          <td style="border-left:0 ;">: {{$kehadiran_siswa->tanpa_keterangan}} hari</td>
          <td class="false"></td>
        </tr>
        @else
        <tr class="nilai">
          <td colspan="4"><b>Data kehadiran belum diinput</b></td>
        </tr>
        @endif
        <!-- End Ketidakhadiran  -->

        <!-- Catatan Wali Kelas -->
        <tr>
          <td colspan="4" style="height: 25px; padding-top: 5px"><strong>F. CATATAN WALI KELAS</strong></td>
        </tr>
        <tr class="sikap">
          <td colspan="4" class="description" style="height: 50px;">
            @if(!is_null($catatan_wali_kelas))
            <i><b>{{$catatan_wali_kelas->catatan}}</b></i>
            @endif
          </td>
        </tr>
        <!-- End Catatan Wali Kelas -->

        <!-- Tanggapan ORANG TUA/WALI -->
        <tr>
          <td colspan="4" style="height: 25px; padding-top: 5px"><strong>G. TANGGAPAN ORANG TUA/WALI</strong></td>
        </tr>
        <tr class="sikap">
          <td colspan="4" class="description" style="height: 45px;">
          </td>
        </tr>
        <!-- End Tanggapan ORANG TUA/WALI -->

        <!-- Keputusan -->
        @if($anggota_kelas->kelas->tapel->semester->semester == 2)
        <tr>
          <td colspan="4" style="height: 25px; padding-top: 5px"><strong>H. KEPUTUSAN</strong></td>
        </tr>
        <tr class="sikap">
          <td colspan="4" class="description" style="height: 45px;">
            Berdasarkan hasil yang dicapai pada semester 1 dan 2, Peserta didik ditetapkan : <br>
            @if(!is_null($anggota_kelas->kenaikan_kelas))
            <b>
              @if($anggota_kelas->kenaikan_kelas->keputusan == 1)
              NAIK KE KELAS : {{$anggota_kelas->kenaikan_kelas->kelas_tujuan}}
              @elseif($anggota_kelas->kenaikan_kelas->keputusan == 2)
              TINGGAL DI KELAS : {{$anggota_kelas->kenaikan_kelas->kelas_tujuan}}
              @elseif($anggota_kelas->kenaikan_kelas->keputusan == 3)
              LULUS
              @elseif($anggota_kelas->kenaikan_kelas->keputusan == 4)
              TIDAK LULUS
              @endif
            </b>
            @endif
          </td>
        </tr>
        @endif
        <!-- End Keputusan -->

      </table>
    </div>

    <div style="padding-top:1rem; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
      <table>
        <tr>
          <td style="width: 30%;">
            Mengetahui <br>
            Orang Tua/Wali, <br><br><br><br>
            .............................
          </td>
          <td style="width: 35%;"></td>
          <td style="width: 35%;">
            {{$anggota_kelas->kelas->tapel->km_tgl_raport->tempat_penerbitan}}, {{$anggota_kelas->kelas->tapel->km_tgl_raport->tanggal_pembagian->isoFormat('D MMMM Y')}}<br>
            Wali Kelas, <br><br><br><br>
            <b><u>{{$anggota_kelas->kelas->guru->nama_lengkap}}, {{$anggota_kelas->kelas->guru->gelar}}</u></b><br>
            NIP. {{konversi_nip($anggota_kelas->kelas->guru->nip)}}
          </td>
        </tr>
        <tr>
          <td style="width: 30%;"></td>
          <td style="width: 35%;">
            Mengetahui <br>
            Kepala Sekolah, <br><br><br><br>
            <b><u>{{$sekolah->kepala_sekolah}}</u></b><br>
            NIP. {{konversi_nip($sekolah->nip_kepala_sekolah)}}
          </td>
          <td style="width: 35%;"></td>
        </tr>
      </table>
    </div>
    <div class="footer">
      <i>{{$anggota_kelas->kelas->nama_kelas}} | {{$anggota_kelas->siswa->nama_lengkap}} | {{$anggota_kelas->siswa->nis}}</i> <b style="float: right;"><i>Halaman 4</i></b>
    </div>
  </div>
</body>

</html>