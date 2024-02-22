<?php

namespace App\Imports;

use App\AnggotaKelas;
use App\User;
use App\Kelas;
use App\Siswa;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToCollection;

class SiswaImport implements ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $row) {
            if ($key < 8) {
                // Skip rows before the data starts
                continue;
            }

            $user = User::create([
                'username' => strtolower(str_replace(' ', '', $row[6] . $row[1])),
                'password' => bcrypt($row[1]),
                'role' => 3,
                'status' => true
            ]);

            // // Convert date values to Unix timestamp
            $tanggal_lahir = Date::excelToTimestamp($row[13]);
            // $tanggal_lahir_ayah = Date::excelToTimestamp($row[31]);
            // $tanggal_lahir_ibu = Date::excelToTimestamp($row[42]);
            // $tanggal_lahir_wali = Date::excelToTimestamp($row[53]);
            // $tanggal_masuk_sekolah_lama =  Date::excelToTimestamp($row[66]);
            // $tanggal_keluar_sekolah_lama = Date::excelToTimestamp($row[67]);

            $tanggal_lahir = $row[13] ? gmdate('Y-m-d', $tanggal_lahir) : null; //bener 
            // $tanggal_lahir_ayah = $row[31] ? gmdate('Y-m-d', $tanggal_lahir_ayah) : null;
            // $tanggal_lahir_ibu = $row[42] ? gmdate('Y-m-d', $tanggal_lahir_ibu) : null;
            // $tanggal_lahir_wali = $row[53] ? gmdate('Y-m-d', $tanggal_lahir_wali) : null;
            // $tanggal_masuk_sekolah_lama = $row[66] ? gmdate('Y-m-d', $tanggal_masuk_sekolah_lama) : null;
            // $tanggal_keluar_sekolah_lama = $row[67] ? gmdate('Y-m-d', $tanggal_keluar_sekolah_lama) : null;

            // dd($tanggal_lahir);

            // // Convert date values to Unix timestamp
            // $tanggal_lahir = null; 
            $tanggal_lahir_ayah =  null;
            $tanggal_lahir_ibu = null;
            $tanggal_lahir_wali = null;
            $tanggal_masuk_sekolah_lama = null;
            $tanggal_keluar_sekolah_lama = null;

            // kelas_id, jurusan_id, tingkatan_id
            // Contoh data dari row
            $namaKelas = $row[5]; // Contoh: 'JHS-10IPS'

            // Pisahkan tingkatan dan jurusan dari nama kelas
            $parts = explode('-', $namaKelas);
            $tingkatan = $parts[0]; // Contoh: 'JHS'
            $jurusan = isset($parts[1]) ? $parts[1] : null; // Contoh: '10IPS'

            // Tentukan tingkatan_id berdasarkan tingkatan
            if ($tingkatan === 'PG') {
                $tingkatanId = 1; // PG
            } elseif ($tingkatan === 'KG') {
                $tingkatanId = 2; // JHS
            } elseif ($tingkatan === 'P') {
                $tingkatanId = 3; // JHS
            } elseif ($tingkatan === 'JHS') {
                $tingkatanId = 4; // JHS
            } elseif ($tingkatan === 'SHS') {
                $tingkatanId = 5; // SHS
            } else {
                $tingkatanId = null; // Tingkatan tidak valid
            }

            // Tentukan jurusan_id berdasarkan jurusan
            if ($jurusan && strpos($jurusan, 'IPS') !== false) {
                $jurusanId = 2; // IPS
            } elseif ($jurusan && strpos($jurusan, 'IPA') !== false) {
                $jurusanId = 1; // IPA
            } else {
                $jurusanId = 3; // Tanpa Jurusan
            }

            // Cari kelas berdasarkan nama_kelas
            $kelas = Kelas::where('nama_kelas', $namaKelas)->first();

            // Jika kelas ditemukan, gunakan id-nya sebagai kelas_id
            $kelasId = $kelas ? $kelas->id : null;

            $siswa = Siswa::create([
                'user_id' => $user->id,
                'nis' => $row[1],
                'nisn' => $row[2],
                'status' => $row[3],
                'jenis_pendaftaran' => $row[4],
                'kelas_id' => $kelasId,
                'tingkatan_id' => $tingkatanId,
                'jurusan_id' => $jurusanId,

                'nama_lengkap' => strtoupper($row[6]),
                'nama_panggilan' => strtoupper($row[7]),
                'nik' => $row[8],
                'jenis_kelamin' => strtoupper($row[9]),
                'blood_type' => strtoupper($row[10]),
                'agama' => $row[11],
                'tempat_lahir' => $row[12],
                'tanggal_lahir' => $tanggal_lahir,
                'anak_ke' => $row[14],
                'jml_saudara_kandung' => $row[15],
                'warga_negara' => $row[16],

                'alamat' => $row[17],
                'kota' => $row[18],
                'kode_pos' => (int)  $row[19],
                'jarak_rumah_ke_sekolah' => $row[20],
                'email' => $row[21],
                'email_parent' => $row[22],
                'nomor_hp' => $row[23],
                'tinggal_bersama' => $row[24],
                'transportasi' => $row[25],

                'nik_ayah' => $row[26],
                'nama_ayah' => $row[27],
                'pekerjaan_ayah' => $row[28],
                'penghasil_ayah' => $row[29],
                'tempat_lahir_ayah' => $row[30],
                'tanggal_lahir_ayah' => $tanggal_lahir_ayah,
                'alamat_ayah' => $row[32],
                'nomor_hp_ayah' => $row[33],
                'agama_ayah' => $row[34],
                'kota_ayah' => $row[35],
                'pendidikan_terakhir_ayah' => $row[36],

                'nik_ibu' => $row[37],
                'nama_ibu' => $row[38],
                'pekerjaan_ibu' => $row[39],
                'penghasil_ibu' => $row[40],
                'tempat_lahir_ibu' => $row[41],
                'tanggal_lahir_ibu' => $tanggal_lahir_ibu,
                'alamat_ibu' => $row[43],
                'nomor_hp_ibu' => $row[44],
                'agama_ibu' => $row[45],
                'kota_ibu' => $row[46],
                'pendidikan_terakhir_ibu' => $row[47],

                'nik_wali' => $row[48],
                'nama_wali' => $row[49],
                'pekerjaan_wali' => $row[50],
                'penghasil_wali' => $row[51],
                'tempat_lahir_wali' => $row[52],
                'tanggal_lahir_wali' => $tanggal_lahir_wali,
                'alamat_wali' => $row[54],
                'nomor_hp_wali' => $row[55],
                'agama_wali' => $row[56],
                'kota_wali' => $row[57],
                'pendidikan_terakhir_wali' => $row[58],

                'tinggi_badan' => $row[59],
                'berat_badan' => $row[60],
                'spesial_treatment' => $row[61],
                'note_kesehatan' => $row[62],

                'prestasi_sekolah_lama' => $row[63],
                'tahun_prestasi_sekolah_lama' => $row[64],
                'sertifikat_number_sekolah_lama' => $row[65],
                'tanggal_masuk_sekolah_lama' => $tanggal_masuk_sekolah_lama,
                'tanggal_keluar_sekolah_lama' => $tanggal_keluar_sekolah_lama,
                'nama_sekolah_lama' => $row[68],
                'alamat_sekolah_lama' => $row[69],
                'no_sttb' => $row[70],
                'nem' => (int) $row[71],

                'avatar' => 'default.png',
            ]);

            AnggotaKelas::create([
                'siswa_id' => $siswa->id,
                'kelas_id' => $siswa->kelas_id,
                'pendaftaran' => $siswa->jenis_pendaftaran,
            ]);
        }
    }
}
