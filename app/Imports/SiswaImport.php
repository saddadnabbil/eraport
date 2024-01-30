<?php

namespace App\Imports;

use App\Siswa;
use App\User;
use Illuminate\Support\Collection;
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
            dd($row);
            if ($key >= 8 && $key <= 300) {
                $user = User::create([
                    'username' => strtolower(str_replace(' ', '', $row[5] . $row[1])),
                    'password' => bcrypt($row[1]),
                    'role' => 3,
                    'status' => true
                ]);

                $tanggal_lahir = ($row[12] - 25569) * 86400;
                Siswa::create([
                    'user_id' => $user->id,
                    'nis' => $row[1],
                    'nisn' => $row[2],
                    'status' => $row[3],
                    'jenis_pendaftaran' => $row[4],

                    'nama_lengkap' => strtoupper($row[5]),
                    'nama_panggilan' => strtoupper($row[6]),
                    'nik' => $row[7],
                    'jenis_kelamin' => strtoupper($row[8]),
                    'blood_type' => strtoupper($row[9]),
                    'agama' => $row[10],
                    'tempat_lahir' => $row[11],
                    'tanggal_lahir' => gmdate('Y-m-d', $tanggal_lahir),
                    'anak_ke' => $row[13],
                    'jml_saudara_kandung' => $row[14],
                    'warga_negara' => $row[15],

                    'alamat' => $row[16],
                    'kota' => $row[17],
                    'kode_pos' => $row[18],
                    'jarak_rumah_ke_sekolah' => $row[19],
                    'email' => $row[20],
                    'email_parent' => $row[21],
                    'nomor_hp' => $row[22],
                    'tinggal_bersama' => $row[23],
                    'transportasi' => $row[24],

                    'nik_ayah' => $row[25],
                    'nama_ayah' => $row[26],
                    'pekerjaan_ayah' => $row[27],
                    'penghasil_ayah' => $row[28],
                    'tempat_lahir_ayah' => $row[29],
                    'tanggal_lahir_ayah' => $row[30],
                    'alamat_ayah' => $row[31],
                    'nomor_hp_ayah' => $row[32],
                    'agama_ayah' => $row[33],
                    'kota_ayah' => $row[34],
                    'pendidikan_terakhir_ayah' => $row[35],

                    'nik_ibu' => $row[36],
                    'nama_ibu' => $row[37],
                    'pekerjaan_ibu' => $row[38],
                    'penghasil_ibu' => $row[39],
                    'tempat_lahir_ibu' => $row[40],
                    'tanggal_lahir_ibu' => $row[41],
                    'alamat_ibu' => $row[42],
                    'nomor_hp_ibu' => $row[43],
                    'agama_ibu' => $row[44],
                    'kota_ibu' => $row[45],
                    'pendidikan_terakhir_ibu' => $row[46],

                    'nik_wali' => $row[47],
                    'nama_wali' => $row[48],
                    'pekerjaan_wali' => $row[49],
                    'penghasil_wali' => $row[50],
                    'tempat_lahir_wali' => $row[51],
                    'tanggal_lahir_wali' => $row[52],
                    'alamat_wali' => $row[53],
                    'nomor_hp_wali' => $row[54],
                    'agama_wali' => $row[55],
                    'kota_wali' => $row[56],
                    'pendidikan_terakhir_wali' => $row[56],

                    'tinggi_badan' => $row[57],
                    'berat_badan' => $row[58],
                    'spesial_treatment' => $row[59],
                    'note_kesehatan' => $row[60],

                    'prestasi_sekolah_lama' => $row[61],
                    'tahun_prestasi_sekolah_lama' => $row[62],
                    'sertifikat_number_sekolah_lama' => $row[63],
                    'tanggal_masuk_sekolah_lama' => $row[64],
                    'tanggal_keluar_sekolah_lama' => $row[65],
                    'nama_sekolah_lama' => $row[66],
                    'alamat_sekolah_lama' => $row[64],
                    'nomor_sttb_sekolah_lama' => $row[67],
                    'nem' => $row[68],

                    'avatar' => 'default.png',
                ]);
            }
        }
    }
}
