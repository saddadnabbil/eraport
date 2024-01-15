<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8" />
    <title>{{$title}} | {{$anggota_kelas->siswa->nama_lengkap}} ({{$anggota_kelas->siswa->nis}})</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/dist/img/logo.png')}}">
    <link href="./assets/eraport.css" rel="stylesheet">
  </head>

  <body>
    <div class="raport">
      <table class="header-table" style="width: 100%; border-collapse: collapse">
        <tr>
            <td class="no-indent left-align">
                <img src="./assets/dist/img/logo.png" alt="" width="80px" height="80px">
            </td>
            
            <td class="title-center">
                <h1 class="center-align pad-179 pad-5 no-indent">
                    GLOBAL INDONESIA SCHOOL <br>
                    
                    @if($anggota_kelas->kelas->tapel->semester->semester == 1)
                    FIRST
                    @else
                    SECOND
                    @endif
                     
                    SEMESTER PROGRESS REPORT <br> 
                    {{str_replace('-', ' / ', $anggota_kelas->kelas->tapel->tahun_pelajaran)}}
                </h1>
                <p class="center-align pad-126 line-height-123" style="padding: 0 60pt">
                    Address : {{$sekolah->alamat}}
                </p>
            </td>
            
            <td class="no-indent right-align">
                <img src="./assets/dist/img/tut-wuri-handayani.png" alt="" width="80px" height="80px">
            </td>
        </tr>
      </table>
  
      <!-- information name -->
      <table class="information-container ml-5 pad-2-1">
        <tr>
          <td><h3>Name</h3></td>
          <td><h3>: {{$anggota_kelas->siswa->nama_lengkap}}</h3></td>
          <td><h3>Class</h3></td>
          <td><h3>: {{$anggota_kelas->kelas->nama_kelas}}</h3></td>
        </tr>
        <tr>
          <td><h3>NIS</h3></td>
          <td><h3>: {{$anggota_kelas->siswa->nis}} </h3></td>
          <td><h3>NISN</h3></td>
          <td><h3>: {{$anggota_kelas->siswa->nisn}}</h3></td>
        </tr>
      </table>
  
      <!-- Nilai raport -->
      <table class="ml-5" style="border-collapse:collapse;margin-left:5.44pt" cellspacing="0">
  
        <!-- Heading table -->
        <tr style="height:14pt">
            <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#999999">
              <p style="text-indent: 0pt;text-align: left;">
                  <br />
              </p>
              <p class="s1" style="padding-left: 3pt;text-indent: 0pt;text-align: left;">No</p>
              <p style="text-indent: 0pt;text-align: left;">
                  <br />
              </p>
            </td>
            <td style="width:181pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#999999">
              <p style="text-indent: 0pt;text-align: left;">
                  <br />
              </p>
              <p class="s1" style="padding-left: 61pt;padding-right: 61pt;text-indent: 0pt;text-align: center;">Subject</p>
            </td>
            <td style="width:56pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#999999">
              <p class="s1" style="padding-top: 2pt;padding-left: 1pt;text-indent: 0pt;text-align: center;">Minimum Passing Mark</p>
            </td>
            <td style="width:48pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#999999">
              <p class="s1" style="padding-top: 2pt;padding-left: 13pt; padding-right: 13pt;text-align: center;">Nilai Akhir</p>
            </td>
  
            <td style="width:48pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#999999">
              <p class="s1" style="padding-top: 6pt;text-align: center;">Grade</p>
            </td>
            <td style="width:187pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#999999">
              <p class="s1" style="padding-top: 6pt;text-align: center;">Capaian Pembelajaran</p>
            </td>
        </tr>
        
        {{-- Content Table --}}
        <?php $no = 0; ?>
        @foreach($nilai_akhir_total as $nilai)
          <?php $no++; ?>
          <tr style="height:25pt">
              <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s2" style="padding-top: 4pt;padding-right: 2pt;text-indent: 0pt;text-align: center;">{{$no}}</p>
              </td>
              <td style="width:181pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s2" style="padding-top: 3pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">{{$nilai['nama_mapel']}}</p>
                <p class="s3" style="padding-top: 2pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">{{$nilai['nama_mapel_indonesian']}}</p>
              </td>
              <td style="width:48pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s2" style="padding-top: 4pt;padding-left: 1pt;text-indent: 0pt;text-align: center;">{{$nilai['kkm']}}</p>
              </td>
              <td style="width:48pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                  <p class="s2" style="padding-top: 4pt;padding-left: 1pt;text-indent: 0pt;text-align: center;">{{$nilai['nilai']}}</p>
              </td>
              <td style="width:48pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s2" style="padding-top: 4pt;padding-left: 1pt;text-indent: 0pt;text-align: center;">{{$nilai['predikat']}}</p>
              </td>
              <td style="width:187px;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s2" style="padding-top: 4pt;padding-bottom: 7pt;padding-left: 4pt; padding-right: 3pt;text-indent: 0pt; line-height: 1.3;">{!! 
                  !is_null($nilai['deskripsi_nilai']) ? nl2br($nilai['deskripsi_nilai']->deskripsi_raport) : '' !!}
                </p>
              </td>
  
          </tr>
        @endforeach
  
      </table>
  
      <p>         
        <br />
      </p>
  
      <!-- Extracurricular -->
      <table style="border-collapse:collapse;margin-left:5.44pt" cellspacing="0">
          <tr style="height:14pt">
            <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#CCCCCC">
              <p class="s1" style="padding-top: 1pt;padding-left: 2pt;padding-right: 1pt;text-indent: 0pt;text-align: center;">No</p>
            </td>
            <td style="width:181pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#CCCCCC">
              <p class="s1" style="padding-top: 1pt;padding-left: 61pt;padding-right: 61pt;text-indent: 0pt;text-align: center;">Extracurricular</p>
            </td>
            <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#CCCCCC">
              <p class="s1" style="padding-top: 1pt;padding-left: 1pt;text-indent: 0pt;text-align: center;">Grade</p>
            </td>
            <td style="width:284pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#CCCCCC">
              <p class="s1" style="padding-top: 1pt;padding-left: 100pt;padding-right: 99pt;text-indent: 0pt;text-align: center;">Remarks</p>
            </td>
          </tr>
          @if(count($data_anggota_ekstrakulikuler) == 0)
          <tr style="height:12pt">
            <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
              <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">-</p>
            </td>
            <td style="width:181pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
              <p class="s5" style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">-</p>
            </td>
            <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
              <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">-</p>
            </td>
            <td style="width:284pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
              <p class="s5" style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">-</p>
            </td>
          </tr>
          @else
              <?php $no = 0; ?>
              @foreach($data_anggota_ekstrakulikuler as $nilai_ekstra)
                <?php $no++; ?>
                <tr style="height:12pt">
                    <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                      <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">{{$no}}</p>
                    </td>
                    <td style="width:181pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                      <p class="s5" style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">{{$nilai_ekstra->ekstrakulikuler->nama_ekstrakulikuler}}</p>
                    </td>
                    <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                      <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">{{$nilai_ekstra->nilai}}</p>
                    </td>
                    <td style="width:284pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                      <p class="s5" style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">{!! nl2br($nilai_ekstra->deskripsi) !!}</p>
                    </td>
                </tr>
              @endforeach
          {{-- @else
            <?php $no = 0; ?>
            @foreach($data_anggota_ekstrakulikuler as $nilai_ekstra)
            <?php $no++; ?> --}}
          @endif 
      </table>
  
      <p>         
        <br />
      </p>
  
      <!-- Achievement -->
      <table style="border-collapse:collapse;margin-left:5.44pt" cellspacing="0">
        <tr style="height:14pt">
            <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#CCCCCC">
              <p class="s1" style="padding: 1pt 0;padding-left: 2pt;padding-right: 1pt;text-indent: 0pt;text-align: center;">No</p>
            </td>
            <td style="width:181pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#CCCCCC">
              <p class="s1" style="padding: 1pt 0;padding-left: 61pt;padding-right: 61pt;text-indent: 0pt;text-align: center;">Achievement</p>
            </td>
            <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#CCCCCC">
              <p class="s1" style="padding: 1pt 0;padding-left: 1pt;text-indent: 0pt;text-align: center;">Level</p>
            </td>
            <td style="width:284pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#CCCCCC">
              <p class="s1" style="padding: 1pt 0;padding-left: 100pt;padding-right: 99pt;text-indent: 0pt;text-align: center;">Name of Competition</p>
            </td>
        </tr>
        @if (count($data_prestasi_siswa) == 0)
        <tr style="height:12pt">
            <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
              <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">-</p>
            </td>
            <td style="width:181pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
              <p class="s5" style="padding: 1pt 0;padding-left: 2pt;text-indent: 0pt;text-align: left;">-</p>
            </td>
            <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
              <p class="s5" style="padding: 1pt 0;text-indent: 0pt;text-align: center;">-</p>
            </td>
            <td style="width:284pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
              <p class="s5" style="padding: 1pt 0;padding-left: 2pt;text-indent: 0pt;text-align: left;">-</p>
            </td>
        </tr>
        @else 
          <?php $no = 0; ?>
          @foreach($data_prestasi_siswa as $prestasi)
          <?php $no++; ?>
          <tr style="height:12pt">
              <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">{{$no}}</p>
              </td>
              <td style="width:181pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s5" style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">{{$prestasi->nama_prestasi}}</p></p>
              </td>
              <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">
                  @if($prestasi->tingkat_prestasi == 1)
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
              <td style="width:284pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s5" style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">{!! nl2br($prestasi->deskripsi) !!}</p>
              </td>
          </tr>
          @endforeach
        @endif
      </table>
  
      <p>         
        <br />
      </p>
  
      <!-- Container Table -->
      <table class="container-table" style="margin-left: 7pt; width: 100%; border-collapse:collapse;">
        <tr>
            <!-- Absences Table -->
            <td style="vertical-align: top;">
              <!-- Absences Scale -->
              <table style="border-collapse:collapse; margin-left: -2px" cellspacing="0">
                  <tr style="height:14pt">
                    <td style="width:190pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="2" bgcolor="#CCCCCC">
                        <p class="s1" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">Absences</p>
                    </td>
                    <td style="width:50pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" bgcolor="#CCCCCC">
                        <p class="s1" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">Days</p>
                    </td>
                  </tr>
                @if(!is_null($kehadiran_siswa))
                  <tr style="height:12pt">
                    <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                      <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">1</p>
                  </td>
                    <td style="width:178pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">Sick</p>
                    </td>
                    <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">{{$kehadiran_siswa->sakit}}</p>
                    </td>
                  </tr>
                  <tr style="height:12pt">
                    <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">2</p>
                    </td>
                    <td style="width:178pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">Permit</p>
                    </td>
                    <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">{{$kehadiran_siswa->izin}}</p>
                    </td>
                  </tr>
                  <tr style="height:12pt">
                    <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">3</p>
                    </td>
                    <td style="width:178pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">Without Permission</p>
                    </td>
                    <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">{{$kehadiran_siswa->tanpa_keterangan}}</p>
                    </td>
                  </tr>
                  <tr style="height:12pt">
                    <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p style="text-indent: 0pt;text-align: left;">
                          <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;"><br></p>
                        </p>
                    </td>
                    <td style="width:178pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p style="text-indent: 0pt;text-align: left;">
                          <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;"><br></p>
                        </p>
                    </td>
                    <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p style="text-indent: 0pt;text-align: left;">
                          <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;"><br></p>
                        </p>
                    </td>
                  </tr>
                @else
                  <tr style="height:12pt">
                    <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                      <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">1</p>
                  </td>
                    <td style="width:178pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">Sick</p>
                    </td>
                    <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">0</p>
                    </td>
                  </tr>
                  <tr style="height:12pt">
                    <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">2</p>
                    </td>
                    <td style="width:178pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">Permit</p>
                    </td>
                    <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">0</p>
                    </td>
                  </tr>
                  <tr style="height:12pt">
                    <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">3</p>
                    </td>
                    <td style="width:178pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">Without Permission</p>
                    </td>
                    <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">0</p>
                    </td>
                  </tr>
                  <tr style="height:12pt">
                    <td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p style="text-indent: 0pt;text-align: left;">
                          <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;"><br></p>
                        </p>
                    </td>
                    <td style="width:178pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p style="text-indent: 0pt;text-align: left;">
                          <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;"><br></p>
                        </p>
                    </td>
                    <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p style="text-indent: 0pt;text-align: left;">
                          <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;"><br></p>
                        </p>
                    </td>
                  </tr>
                @endif
              </table>
            </td>
            <!-- Grading Scale Table -->
            <td style="vertical-align: top;">
              <!-- Grading Scale -->
              <table style="border-collapse:collapse; margin-left: 0; padding-right: 10px" cellspacing="0">
                  <tr style="height:14pt">
                    <td style="width:278pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="3" bgcolor="#CCCCCC">
                        <p class="s1" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">Grading Scale</p>
                    </td>
                  </tr>
                  <tr style="height:12pt">
                    <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">A</p>
                    </td>
                    <td style="width:85pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;ext-indent: 0pt;text-align: center;">80.00 - 100.00</p>
                    </td>
                    <td style="width:136pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">Very Good</p>
                    </td>
                  </tr>
                  <tr style="height:12pt">
                    <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">B</p>
                    </td>
                    <td style="width:85pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">70.00 - 79.99</p>
                    </td>
                    <td style="width:136pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">Good</p>
                    </td>
                  </tr>
                  <tr style="height:12pt">
                    <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">C</p>
                    </td>
                    <td style="width:85pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">60.00 - 69.99</p>
                    </td>
                    <td style="width:136pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">Fair</p>
                    </td>
                  </tr>
                  <tr style="height:12pt"> 
                    <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">D</p>
                    </td>
                    <td style="width:85pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">0.00 - 59.99</p>
                    </td>
                    <td style="width:136pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                        <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: center;">Poor</p>
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
      <table style="border-collapse:collapse; margin-left: 5.44pt;" cellspacing="0">
        <tr style="height:14pt">
            <td style="width:722px;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="3" bgcolor="#CCCCCC">
              <p class="s1" style="padding-top: 1pt;padding-left: 110pt;padding-right: 110pt;text-indent: 0pt;text-align: center;">Homeroom Teacher&#39;s Comments</p>
            </td>
        </tr>
        <tr style="height:14pt">
            <td style="width:278pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="3">
              <p class="s5" style="padding-top: 1pt;text-indent: 0pt;text-align: left; padding-left: 2pt;">           
                @if(!is_null($catatan_wali_kelas))
                  {{$catatan_wali_kelas->catatan}}
                @else 
                  -
                @endif</p>
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
              <p class="s6" style="padding-top: 10pt; text-align: center;">Parent's / Guardian's Signature</p>
              <p class="s7" style="padding-top: 48pt; text-align: center; border-bottom: 1px solid black; display: inline-block; max-width: 200px; width: 120px; margin: 0 auto; "></p>
          </td>
          <!-- Teacher's Section -->
          <td style="width: 50%; text-align: center;">
              <p class="s6" style="text-align: center;">
                {{-- Serang, January 09, 2024<br>Homeroom Teacher --}}
                {{$anggota_kelas->kelas->tapel->km_tgl_raport->tempat_penerbitan}}, {{$anggota_kelas->kelas->tapel->km_tgl_raport->tanggal_pembagian->isoFormat('MMMM D, Y')}}<br>Homeroom Teacher
              </p>
              <p class="s7" style="padding-top: 37pt; text-align: center; border-bottom: 1px solid black; display: inline-block; width: auto;">{{$anggota_kelas->kelas->guru->nama_lengkap}}, {{$anggota_kelas->kelas->guru->gelar}}</p>
          </td>
        </tr>
        <!-- Bottom Section -->
        <tr>
          <td colspan="2" style="text-align: center; margin-top: 15px;">
              <p class="s6" style="padding-top: 6pt; text-align: center;">Principal's Signature</p>
              <p class="s7" style="padding-top: 37pt; text-align: center; border-bottom: 1px solid black; display: inline-block; width: auto;">{{$sekolah->kepala_sekolah}}</p>
          </td>
        </tr>
      </table>
    </div>
    

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

    <!-- Page 2 sumatif  -->
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
                @if ($nilai_kelompok_a->km_deskripsi_nilai_siswa->deskripsi_raport)
                    {!! nl2br($nilai_kelompok_a->km_deskripsi_nilai_siswa->deskripsi_raport) !!}
                @endif 
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
                @if ($nilai_kelompok_b->km_deskripsi_nilai_siswa)
                    {!! nl2br($nilai_kelompok_b->km_deskripsi_nilai_siswa->deskripsi_raport) !!}
                @endif
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
              <span>{!! nl2br($nilai_kelompok_a->km_deskripsi_nilai_siswa->deskripsi_raport) !!}</span>
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
              <span>{!! nl2br($nilai_kelompok_b->km_deskripsi_nilai_siswa->deskripsi_raport) !!}</span>
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
    </div> --}}
    </body>
</html>