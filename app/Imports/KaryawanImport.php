<?php

namespace App\Imports;

use App\Karyawan;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class KaryawanImport implements ToCollection
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

            // Create User
            $user = User::create([
                'username' => strtolower(str_replace(' ', '', $row[5] . $row[1])),
                'password' => bcrypt($row[1]),
                'role' => 3,
                'status' => true
            ]);

            // Create Karyawan
            Karyawan::create([
                'user_id' => $user->id,
                'status' => $row[1],
                'status_karyawan_id' => $row[2],
                'unit_karyawan_id' => $row[3],
                'position_karyawan_id' => $row[4],
                'join_date' => gmdate('Y-m-d', Date::excelToTimestamp($row[5])),
                'permanent_date' => gmdate('Y-m-d', Date::excelToTimestamp($row[6])),

                'kode_karyawan' => $row[7],
                'nama_lengkap' => strtoupper($row[8]),
                'nik' => $row[9],
                'nomor_akun' => $row[10],
                'nomor_fingerprint' => $row[11],

                'nomor_taxpayer' => $row[12],
                'nama_taxpayer' => $row[13],
                'nomor_bpjs_ketenagakerjaan' => $row[14],
                'iuran_bpjs_ketenagakerjaan' => $row[15],
                'nomor_bpjs_yayasan' => $row[16],
                'nomor_bpjs_pribadi' => $row[17],

                'jenis_kelamin' => strtoupper($row[18]),
                'agama' => $row[19],
                'tempat_lahir' => $row[20],
                'tanggal_lahir' => gmdate('d-m-Y', Date::excelToTimestamp($row[21])),
                'alamat' => $row[22],
                'alamat_sekarang' => $row[23],
                'kota' => $row[24],
                'kode_pos' => $row[25],
                'nomor_phone' => $row[26],
                'nomor_hp' => $row[27],
                'email' => $row[28],
                'email_sekolah' => $row[29],
                'warga_negara' => $row[30],
                'status_pernikahan' => $row[31],
                'nama_pasangan' => $row[32],
                'jumlah_anak' => $row[33],
                'keterangan' => $row[34],

                'avatar' => 'default.png',
            ]);
        }
    }
}
