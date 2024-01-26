@include('layouts.main.header')
@include('layouts.sidebar.admin')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{$title}}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item "><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- ./row -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-list-ol"></i> {{$title}}</h3>
            </div>

            <div class="card-body">
              <div class="callout callout-info">
                <form action="{{ route('penilaiankm.create') }}" method="GET">
                  @csrf
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Semester</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" value="{{$semester->id}}" disabled>
                    </div>
                    <label class="col-sm-2 col-form-label">Term</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" value="{{$term->term}}" disabled>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kelas</label>
                    <div class="col-sm-10">
                      <select class="form-control select2" name="pembelajaran_id" style="width: 100%;" required onchange="this.form.submit();">
                        <option value="" disabled>-- Pilih Kelas --</option>
                        @foreach($data_pembelajaran as $pembelajaran)
                        <option value="{{$pembelajaran->id}}" @if ($pembelajaran->id==$pembelajaran_id ) selected @endif>{{$pembelajaran->mapel->nama_mapel}} ({{$pembelajaran->kelas->nama_kelas}} - {{$pembelajaran->kelas->tingkatan->nama_tingkatan}})</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </form>
              </div>

              <form action="{{ route('penilaiankm.store') }}" method="POST">
                @csrf
                <input type="hidden" name="pembelajaran_id" value="{{$pembelajaran_id}}">
                <input type="hidden" name="term_id" value="{{$term->id}}">
                <input type="hidden" name="semester_id" value="{{$semester->id}}">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead class="bg-primary">
                      <tr>
                        @php
                        $count_cp_formatif = $count_cp_formatif + 1;
                        $count_cp_sumatif = $count_cp_sumatif + 1;
                        @endphp
                        <th rowspan="2" colspan="1" class="text-center" style="vertical-align: middle">No</th>
                        <th rowspan="2" colspan="1" class="text-center" style="vertical-align: middle">Nama Siswa</th>
                        <th colspan="{{$count_cp_formatif}}" class="text-center" title data-toggle="popover" data-placement="top" data-content="<b>Penilaian Formatif <br> Bobot: 70</br>">Formatif (F)</th>
                        <th colspan="{{$count_cp_sumatif}}" class="text-center" title data-toggle="popover" data-placement="top"  data-content="<b>Penilaian Sumatif <br> Bobot: 30</b>">Sumatif (S)</th>
                        <th colspan="2" class="text-center">Nilai Raport</th>
                      </tr>
                      <tr>
                        @foreach($rencana_penilaian_data_formatif as $rencana_penilaian_formatif)
                            <input type="hidden" name="rencana_nilai_formatif_id[]" value="{{$rencana_penilaian_formatif['id']}}">
                            <input type="hidden" name="bobot_rencana_nilai_formatif_id[]" value="{{$rencana_penilaian_formatif['bobot']}}">
                            <th class="text-center" data-toggle="popover" data-placement="right" title data-content="<b>{{$rencana_penilaian_formatif['teknik_penilaian']}}<br> Bobot:{{$rencana_penilaian_formatif['bobot']}}</b><br></b>">
                              (F) {{$rencana_penilaian_formatif['kode_penilaian']}}
                            </th>
                        @endforeach
                        <th class="text-center red" data-toggle="popover" data-placement="right" data-content="<b>Nilai Akhir Formatif</b>">NA (F)</th>

                        @foreach($rencana_penilaian_data_sumatif as $rencana_penilaian_sumatif)
                            <input type="hidden" name="rencana_nilai_sumatif_id[]" value="{{$rencana_penilaian_sumatif['id']}}">
                            <input type="hidden" name="bobot_rencana_nilai_sumatif_id[]" value="{{$rencana_penilaian_sumatif['bobot']}}">
                            <th class="text-center" data-toggle="popover" data-placement="right" title data-content="<b>{{$rencana_penilaian_sumatif['teknik_penilaian']}}<br> Bobot:{{$rencana_penilaian_sumatif['bobot']}}</b><br> <b></b> ">
                              (S) {{$rencana_penilaian_sumatif['kode_penilaian']}}
                            </th>
                        @endforeach
                        <th class="text-center red" data-toggle="popover" data-placement="right" data-content="<b>Nilai Akhir Sumulatif</b>">NA (S)</th>

                        <th class="text-center red" data-toggle="popover" data-placement="right" data-content="<b>Nilai Rapor Akhir<br/>Sesuai Perhitungan Sistem</b>"> Akhir</th>
                        <th class="text-center" data-toggle="popover" data-placement="right" data-content="<b>Nilai Rapor Akhir<br/>Sesuai Revisi Guru</b> <br/> Jika terdapat nilai pada kolom ini, maka nilai di kolom inilah yang akan digunakan di rapor."> Revisi</th>
                      </tr>

                    </thead>
                    <tbody>
                      <?php $no = 0; ?>
                      @if (!$data_anggota_kelas->isEmpty())
                        @foreach($data_anggota_kelas->sortBy('siswa.nama_lengkap') as $anggota_kelas)
                            <?php $no++; ?>
                            <tr>
                                <td class="text-center">{{$no}}</td>
                                <td>{{$anggota_kelas->siswa->nama_lengkap}}</td>
                                <input type="hidden" name="anggota_kelas_id[]" value="{{$anggota_kelas->id}}">

                                <?php $i = 0; ?>
                                @foreach($data_rencana_penilaian_formatif as $rencana_penilaian_formatif)
                                    @if ($rencana_penilaian_formatif->nilai_formatif->isEmpty())
                                        <td>
                                            <input type="number" class="form-control nilai_formatif_input" data-bobot="{{$rencana_penilaian_formatif->bobot_teknik_penilaian}}" name="nilai_formatif[{{$i}}][]" min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus berisi antara 0 s/d 100')" oninput="setCustomValidity('')" style="text-align: center;" > 
                                        </td>
                                    @else
                                        @foreach($rencana_penilaian_formatif->nilai_formatif as $nilai_formatif)
                                            @if ($nilai_formatif->anggota_kelas_id == $anggota_kelas->id)
                                            <td>
                                                <input type="number" class="form-control nilai_formatif_input" data-bobot="{{$rencana_penilaian_formatif->bobot_teknik_penilaian}}" name="nilai_formatif[{{$i}}][]" min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus berisi antara 0 s/d 100')" oninput="setCustomValidity('')" style="text-align: center;" value="{{$nilai_formatif->nilai}}"> 
                                            </td>
                                            @endif
                                        @endforeach
                                    @endif
                                    <?php $i++; ?>
                                @endforeach
                                <td class="red nilai-proses" name="nilaiAkhirFormatif">{{$nilaiAkhirFormatif}} </td>
                                <input type="hidden" name="nilaiAkhirFormatif" id="nilaiAkhirFormatif" >

                                <?php $i = 0; ?> 
                                @foreach($data_rencana_penilaian_sumatif as $rencana_penilaian_sumatif)
                                    @if ($rencana_penilaian_sumatif->nilai_sumatif->isEmpty())
                                        <td>
                                            <input type="number" class="form-control nilai_sumatif_input" data-bobot="{{$rencana_penilaian_sumatif->bobot_teknik_penilaian}}" name="nilai_sumatif[{{$i}}][]" min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus berisi antara 0 s/d 100')" oninput="setCustomValidity('')" style="text-align: center;" > 
                                        </td>
                                    @elseif($rencana_penilaian_sumatif->nilai_sumatif != null)
                                        @foreach($rencana_penilaian_sumatif->nilai_sumatif as $nilai_sumatif)
                                            @if ($nilai_sumatif->anggota_kelas_id == $anggota_kelas->id)
                                              <td>
                                                  <input type="number" class="form-control nilai_sumatif_input" data-bobot="{{$rencana_penilaian_sumatif->bobot_teknik_penilaian}}" name="nilai_sumatif[{{$i}}][]" min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus berisi antara 0 s/d 100')" oninput="setCustomValidity('')" style="text-align: center;" value="{{$nilai_sumatif->nilai}}"> 
                                              </td>
                                            @endif
                                        @endforeach
                                    @endif
                                    <?php $i++; ?> 
                                @endforeach
                                <td class="red nilai-proses" name="nilaiAkhirSumatif">{{ $nilaiAkhirSumatif }}</td>
                                <input type="hidden" name="nilaiAkhirSumatif" id="nilaiAkhirSumatif" >

                                <td class="red nilai-proses" id="nilaiAkhirRaportDisplay">{{ $anggota_kelas->nilaiAkhirRaport }}</td>
                                <input type="hidden" name="nilaiAkhirRaport" id="nilaiAkhirRaportInput" >
                                <td>
                                    <input type="number" class="form-control" name="nilai_revisi[]" min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus berisi antara 0 s/d 100')" oninput="setCustomValidity('')" style="text-align: center;" value="{{$anggota_kelas->nilaiAkhirRevisi}}"> 
                                </td>
                            </tr>
                        @endforeach
                      @else
                        <tr>
                          <td class="text-center" colspan="12">Data tidak tersedia.</td>
                        </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
                <p id="demo"></p>
                </div>

                <div class="card-footer clearfix">
                  <button type="submit" class="btn btn-primary float-right">Simpan</button>
                  <a href="{{ route('penilaiankm.index') }}" class="btn btn-default float-right mr-2">Batal</a>
                </div>
              </form>
          </div>
          <!-- /.card -->
        </div>

      </div>
      <!-- /.row -->
    </div>
    <!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('layouts.main.footer')

<script>

$(function() {
    $('[data-toggle="popover"]').popover({
        trigger: 'hover',
        placement: function (popoverEl, targetEl) {
            return $(targetEl).data('placement');
        },
        html: true,
    });
});

$(document).ready(function() {
    // Menghitung nilai akhir untuk setiap baris yang ada saat halaman dimuat
    $('tbody tr').each(function() {
        var row = $(this);
        updateNilaiAkhirFormatif(row);
        updateNilaiAkhirSumatif(row);
        updateNilaiAkhirRaport(row);
    });
});

$(document).ready(function() {
    $('tbody tr').each(function() {
        var row = $(this);
        updateNilaiAkhirFormatif(row);
        updateNilaiAkhirSumatif(row);
        updateNilaiAkhirRaport(row);
    });

    $('.nilai_formatif_input').on('input', function() {
        var row = $(this).closest('tr');  // Ambil baris terdekat
        updateNilaiAkhirFormatif(row);
    });

    function updateNilaiAkhirFormatif(row) {
        var sum = 0;
        var totalBobot = 0;

        row.find('.nilai_formatif_input').each(function() {
            var value = parseInt($(this).val());
            var bobot = parseFloat($(this).data('bobot'));

            console.log(value, bobot);

            if (!isNaN(value) && !isNaN(bobot)) {
                sum += value * bobot;
                totalBobot += bobot;
            }
        });

        var average = totalBobot > 0 ? sum / totalBobot : 0;
        var averageFormatted = (average % 1 === 0) ? average.toFixed(0) : average.toFixed(0);

        row.find('td[name="nilaiAkhirFormatif"]').text(averageFormatted);
        row.find('[name="nilaiAkhirFormatif"]').val(averageFormatted);
    }

    $('.nilai_sumatif_input').on('input', function() {
        var row = $(this).closest('tr');  // Ambil baris terdekat
        updateNilaiAkhirSumatif(row);
    });

    // Fungsi untuk menghitung nilai akhir sumatif berdasarkan bobot
    function updateNilaiAkhirSumatif(row) {
        var sum = 0;
        var totalBobot = 0;

        row.find('.nilai_sumatif_input').each(function() {
            var value = parseInt($(this).val());
            var bobot = parseFloat($(this).data('bobot'));

            if (!isNaN(value) && !isNaN(bobot)) {
                sum += value * bobot;
                totalBobot += bobot;
            }
        });

        var average = totalBobot > 0 ? sum / totalBobot : 0;
        var averageFormatted = (average % 1 === 0) ? average.toFixed(0) : average.toFixed(0);

        row.find('td[name="nilaiAkhirSumatif"]').text(averageFormatted);
        row.find('[name="nilaiAkhirSumatif"]').val(averageFormatted);
    }

    $('.nilai_sumatif_input, .nilai_formatif_input').on('input', function() {
        var row = $(this).closest('tr');  // Ambil baris terdekat
        updateNilaiAkhirRaport(row);
    });

    function updateNilaiAkhirRaport(row) {
        var sumSumatif = 0;
        var countSumatif = 0;
        row.find('.nilai_sumatif_input').each(function() {
            var value = parseInt($(this).val());
            if (!isNaN(value)) {
                sumSumatif += value;
                countSumatif++;
            }
        });

        var sumFormatif = 0;
        var countFormatif = 0;
        row.find('.nilai_formatif_input').each(function() {
            var value = parseInt($(this).val());
            if (!isNaN(value)) {
                sumFormatif += value;
                countFormatif++;
            }
        });

        var bobotSumatif = 0.3;
        var bobotFormatif = 0.7;

        // Pastikan semua variabel memiliki nilai yang valid sebelum melakukan operasi matematika
        if (sumSumatif !== null && countSumatif !== 0 && bobotSumatif !== null &&
            sumFormatif !== null && countFormatif !== 0 && bobotFormatif !== null) {

            var nilaiAkhir = ((sumSumatif / countSumatif) * bobotSumatif) + ((sumFormatif / countFormatif) * bobotFormatif);

        } else {
            var nilaiAkhir = 0;
        }

        // Menghilangkan angka desimal jika angka desimalnya adalah 0
        var nilaiAkhirFormatted = (nilaiAkhir % 1 === 0) ? nilaiAkhir.toFixed(0) : nilaiAkhir.toFixed(0);

        row.find('#nilaiAkhirRaportDisplay').text(nilaiAkhirFormatted);
        row.find('#nilaiAkhirRaportInput').val(nilaiAkhirFormatted);
    }
});




</script>