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
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img" src="/assets/dist/img/avatar/{{$siswa->avatar}}" alt="Avatar" style="border: none">
              </div>

              <h3 class="profile-username text-center">{{$siswa->nama_lengkap}}</h3>

              <p class="text-muted text-center">Administrator</p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Status</b> <a class="float-right">
                      @if($siswa->user->status == true && $siswa->status == true)
                        <span class="badge bg-success">Active</span>
                      @else
                        <span class="badge bg-danger">Non Active</span>
                      @endif
                  </a>
                </li>
                <li class="list-group-item">
                  <b>Username</b> <a class="float-right">{{$siswa->user->username}}</a>
                </li>
                <li class="list-group-item">
                  <b>Email</b> <a class="float-right">{{$siswa->email}}</a>
                </li>
                <li class="list-group-item">
                  <b>Nomor HP</b> <a class="float-right">{{$siswa->nomor_hp}}</a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-user"></i> Data Pribadi</h3>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="form-group row">
                <label for="nama_lengkap" class="col-sm-3 col-form-label">Nama Siswa</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Siswa" value="{{$siswa->nama_lengkap}}" disabled readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-9 pt-1">
                  <label class="form-check-label mr-3"><input type="radio" name="jenis_kelamin" value="Male" @if ($siswa->jenis_kelamin=='Male' ) checked @endif disabled readonly> Male</label>
                  <label class="form-check-label mr-3"><input type="radio" name="jenis_kelamin" value="Female" @if ($siswa->jenis_kelamin=='Female' ) checked @endif disabled readonly> Female</label>
                </div>
              </div>
              <div class="form-group row">
                <label for="nis" class="col-sm-3 col-form-label">NIS</label>
                <div class="col-sm-3">
                  <input type="number" class="form-control" id="nis" name="nis" placeholder="NIS" value="{{$siswa->nis}}" disabled readonly>
                </div>
                <label for="nisn" class="col-sm-2 col-form-label">NISN </label>
                <div class="col-sm-4">
                  <input type="number" class="form-control" id="nisn" name="nisn" placeholder="NISN" value="{{$siswa->nisn}}" disabled readonly> 
                </div>
              </div>
              <div class="form-group row">
                <label for="tempat_lahir" class="col-sm-3 col-form-label">Tempat Lahir</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir" value="{{$siswa->tempat_lahir}}" disabled readonly>
                </div>
                <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-4">
                  <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{$siswa->tanggal_lahir->format('Y-m-d')}}" disabled readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="agama" class="col-sm-3 col-form-label">Agama</label>
                <div class="col-sm-3">
                  <select class="form-control" name="agama" disabled readonly>
                    <option value="{{$siswa->agama}}" selected >
                      @if($siswa->agama == 1)
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
                    </option>
                  </select>
                </div>
                <label for="anak_ke" class="col-sm-2 col-form-label">Anak Ke</label>
                <div class="col-sm-4">
                  <input type="number" class="form-control" id="anak_ke" name="anak_ke" value="{{$siswa->anak_ke}}" disabled readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="status_dalam_keluarga" class="col-sm-3 col-form-label">Status Dalam Keluarga</label>
                <div class="col-sm-9 pt-1">
                  <label class="form-check-label mr-3"><input type="radio" name="status_dalam_keluarga" value="1" @if ($siswa->status_dalam_keluarga=='1' ) checked @endif disabled readonly> Anak Kandung</label>
                  <label class="form-check-label mr-3"><input type="radio" name="status_dalam_keluarga" value="2" @if ($siswa->status_dalam_keluarga=='2' ) checked @endif disabled readonly> Anak Angkat</label>
                  <label class="form-check-label mr-3"><input type="radio" name="status_dalam_keluarga" value="3" @if ($siswa->status_dalam_keluarga=='3' ) checked @endif disabled readonly> Anak Tiri</label>
                </div>
              </div>
              <div class="form-group row">
                <label for="nuptk" class="col-sm-3 col-form-label">Alamat</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat lengkap" disabled readonly>{{$siswa->alamat}}</textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="nomor_hp" class="col-sm-3 col-form-label">Nomor HP</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" id="nomor_hp" name="nomor_hp" placeholder="Nomor HP" value="{{$siswa->nomor_hp}}" disabled readonly>
                </div>
              </div>

              <div class="form-group row">
                <label for="nama_ayah" class="col-sm-3 col-form-label">Nama Ayah</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" placeholder="Nama Ayah" value="{{$siswa->nama_ayah}}" disabled readonly>
                </div>
                <label for="nama_ibu" class="col-sm-2 col-form-label">Nama Ibu</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" placeholder="Nama Ibu" value="{{$siswa->nama_ibu}}" disabled readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="pekerjaan_ayah" class="col-sm-3 col-form-label">Pekerjaan Ayah</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah" placeholder="Pekerjaan Ayah" value="{{$siswa->pekerjaan_ayah}}" disabled readonly>
                </div>
                <label for="pekerjaan_ibu" class="col-sm-2 col-form-label">Pekerjaan Ibu</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu" placeholder="Pekerjaan Ibu" value="{{$siswa->pekerjaan_ibu}}" disabled readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="nama_wali" class="col-sm-3 col-form-label">Nama Wali</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="nama_wali" name="nama_wali" placeholder="Nama Wali" value="{{$siswa->nama_wali}}" disabled readonly>
                </div>
                <label for="pekerjaan_wali" class="col-sm-2 col-form-label">Pekerjaan Wali</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="pekerjaan_wali" name="pekerjaan_wali" placeholder="Pekerjaan Wali" value="{{$siswa->pekerjaan_wali}}" disabled readonly>
                </div>
              </div>

              <a href="{{ route('siswa.index')}}" class="btn btn-success btn-sm">Kembali</a>
              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-edit{{$siswa->id}}">Edit</button>
              @if($siswa->status != false && $siswa->user->status != false)
              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-registrasi{{$siswa->id}}" title="Non Active Siswa">
                Non Active
              </button>
              @else
              <form action="{{ route('siswa.activate') }}" method="POST" style="display: inline-block;">
                  @csrf
                  <input type="hidden" name="id" value="{{ $siswa->id }}">
                  <button type="submit" class="btn btn-warning btn-sm" onclick="confirmAndSubmit('{{$title}}', {{$siswa->id}})">Activate</button>
              </form>
              @endif
              
            </div><!-- /.card-body -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->

        <!-- Modal edit  -->
        <div class="modal fade" id="modal-edit{{$siswa->id}}">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Edit {{$title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                {{ method_field('PATCH') }}
                @csrf
                <div class="modal-body">
                  <div class="form-group row">
                    <label for="nama_lengkap" class="col-sm-3 col-form-label">Nama Siswa</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Siswa" value="{{$siswa->nama_lengkap}}" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-9 pt-1">
                      <label class="form-check-label mr-3"><input type="radio" name="jenis_kelamin" value="Male" @if ($siswa->jenis_kelamin=='Male' ) checked @endif required> Male</label>
                      <label class="form-check-label mr-3"><input type="radio" name="jenis_kelamin" value="Female" @if ($siswa->jenis_kelamin=='Female' ) checked @endif required> Female</label>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="kelas_id" class="col-sm-3 col-form-label">Kelas</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="kelas_id">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($data_kelas_all as $kelas_id)
                        <option value="{{$kelas_id->id}}" @if ($siswa->kelas_id == $kelas_id->id) selected @endif>{{$kelas_id->nama_kelas}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="nis" class="col-sm-3 col-form-label">NIS</label>
                    <div class="col-sm-3">
                      <input type="number" class="form-control" id="nis" name="nis" placeholder="NIS" value="{{$siswa->nis}}">
                    </div>
                    <label for="nisn" class="col-sm-2 col-form-label">NISN <small><i>(Opsional)</i></small></label>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" id="nisn" name="nisn" placeholder="NISN" value="{{$siswa->nisn}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="tempat_lahir" class="col-sm-3 col-form-label">Tempat Lahir</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir" value="{{$siswa->tempat_lahir}}">
                    </div>
                    <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-4">
                      <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{$siswa->tanggal_lahir->format('Y-m-d')}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="agama" class="col-sm-3 col-form-label">Agama</label>
                    <div class="col-sm-3">
                      <select class="form-control" name="agama" required>
                        <option value="{{$siswa->agama}}" selected>
                          @if($siswa->agama == 1)
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
                        </option>
                        <option value="1">Islam</option>
                        <option value="2">Protestan</option>
                        <option value="3">Katolik</option>
                        <option value="4">Hindu</option>
                        <option value="5">Budha</option>
                        <option value="6">Khonghucu</option>
                        <option value="7">Kepercayaan</option>
                      </select>
                    </div>
                    <label for="anak_ke" class="col-sm-2 col-form-label">Anak Ke</label>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" id="anak_ke" name="anak_ke" value="{{$siswa->anak_ke}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="status_dalam_keluarga" class="col-sm-3 col-form-label">Status Dalam Keluarga</label>
                    <div class="col-sm-9 pt-1">
                      <label class="form-check-label mr-3"><input type="radio" name="status_dalam_keluarga" value="1" @if ($siswa->status_dalam_keluarga=='1' ) checked @endif required> Anak Kandung</label>
                      <label class="form-check-label mr-3"><input type="radio" name="status_dalam_keluarga" value="2" @if ($siswa->status_dalam_keluarga=='2' ) checked @endif required> Anak Angkat</label>
                      <label class="form-check-label mr-3"><input type="radio" name="status_dalam_keluarga" value="3" @if ($siswa->status_dalam_keluarga=='3' ) checked @endif required> Anak Tiri</label>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="nuptk" class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat lengkap">{{$siswa->alamat}}</textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="nomor_hp" class="col-sm-3 col-form-label">Nomor HP <small><i>(opsional)</i></small></label>
                    <div class="col-sm-9">
                      <input type="number" class="form-control" id="nomor_hp" name="nomor_hp" placeholder="Nomor HP" value="{{$siswa->nomor_hp}}">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="nama_ayah" class="col-sm-3 col-form-label">Nama Ayah</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" placeholder="Nama Ayah" value="{{$siswa->nama_ayah}}">
                    </div>
                    <label for="nama_ibu" class="col-sm-2 col-form-label">Nama Ibu</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" placeholder="Nama Ibu" value="{{$siswa->nama_ibu}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="pekerjaan_ayah" class="col-sm-3 col-form-label">Pekerjaan Ayah</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah" placeholder="Pekerjaan Ayah" value="{{$siswa->pekerjaan_ayah}}">
                    </div>
                    <label for="pekerjaan_ibu" class="col-sm-2 col-form-label">Pekerjaan Ibu</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu" placeholder="Pekerjaan Ibu" value="{{$siswa->pekerjaan_ibu}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="nama_wali" class="col-sm-3 col-form-label">Nama Wali <small><i>(Opsional)</i></small></label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="nama_wali" name="nama_wali" placeholder="Nama Wali" value="{{$siswa->nama_wali}}">
                    </div>
                    <label for="pekerjaan_wali" class="col-sm-2 col-form-label">Pekerjaan Wali <small><i>(Opsional)</i></small></label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="pekerjaan_wali" name="pekerjaan_wali" placeholder="Pekerjaan Wali" value="{{$siswa->pekerjaan_wali}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="nama_lengkap" class="col-sm-3 col-form-label">Photo</label>
                    <div class="col-sm-9">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="avatar" id="customFile" accept="image/*">
                        <label class="custom-file-label" for="customFile">{{$siswa->avatar}}</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-end">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- End Modal edit -->

        <!-- Modal Registrasi  -->
        @if($siswa->kelas_id != null)
        <div class="modal fade" id="modal-registrasi{{$siswa->id}}">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Registrasi Siswa Keluar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{ route('siswa.registrasi') }}" method="POST">
                @csrf
                <div class="modal-body">
                  <div class="callout callout-info">
                    <h5>Diisi saat siswa keluar dari sekolah</h5>
                    <p>Siswa yang dapat diluluskan hanyalah siswa yang berada pada kelas tingkat akhir pada semester genap.</p>
                  </div>
                  <input type="hidden" name="siswa_id" value="{{$siswa->id}}">
                  <div class="form-group row">
                    <label for="nama_lengkap" class="col-sm-3 col-form-label">Nama Siswa</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Siswa" value="{{$siswa->nama_lengkap}}" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="keluar_karena" class="col-sm-3 col-form-label">Keluar Karena</label>
                    <div class="col-sm-9 pt-1">
                      <select class="form-control select2" name="keluar_karena" style="width: 100%;" required>
                        <option value="">-- Pilih Jenis Keluar --</option>
                        @if($siswa->kelas->tingkatan_id == $tingkatan_akhir && $siswa->kelas->tapel->semester == 2)
                          <option value="Lulus">Lulus</option>
                        @endif
                        <option value="Mutasi">Mutasi</option>
                        <option value="Dikeluarkan">Dikeluarkan</option>
                        <option value="Mengundurkan Diri">Mengundurkan Diri</option>
                        <option value="Putus Sekolah">Putus Sekolah</option>
                        <option value="Wafat">Wafat</option>
                        <option value="Hilang">Hilang</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="tanggal_keluar" class="col-sm-3 col-form-label">Tanggal Keluar Sekolah</label>
                    <div class="col-sm-9">
                      <input type="date" class="form-control" id="tanggal_keluar" name="tanggal_keluar">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="alasan_keluar" class="col-sm-3 col-form-label">Alasan Keluar</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" id="alasan_keluar" name="alasan_keluar" placeholder="Alasan Keluar"></textarea>
                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-end">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        @endif
        <!-- End Modal Registrasi -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('layouts.main.footer')