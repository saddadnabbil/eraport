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
                'status_karyawan_id' => $row[1],
                'unit_karyawan_id' => $row[2],
                'position_karyawan_id' => $row[3],
                'join_date' => gmdate('Y-m-d', Date::excelToTimestamp($row[4])),
                'permanent_date' => gmdate('Y-m-d', Date::excelToTimestamp($row[5])),

                'kode_karyawan' => $row[6],
                'nama_lengkap' => strtoupper($row[7]),
                'nik' => $row[8],
                'nomor_akun' => $row[9],
                'nomor_fingerprint' => $row[10],

                'nomor_taxpayer' => $row[11],
                'nama_taxpayer' => $row[12],
                'nomor_bpjs_ketenagakerjaan' => $row[13],
                'iuran_bpjs_ketenagakerjaan' => $row[14],
                'nomor_bpjs_yayasan' => $row[15],
                'nomor_bpjs_pribadi' => $row[16],

                'jenis_kelamin' => strtoupper($row[17]),
                'agama' => $row[18],
                'tempat_lahir' => $row[19],
                'tanggal_lahir' => gmdate('Y-m-d', Date::excelToTimestamp($row[20])),
                'alamat' => $row[21],
                'alamat_sekarang' => $row[22],
                'kota' => $row[23],
                'kode_pos' => $row[24],
                'nomor_phone' => $row[25],
                'nomor_hp' => $row[26],
                'email' => $row[27],
                'email_sekolah' => $row[28],
                'warga_negara' => $row[29],
                'status_pernikahan' => $row[30],
                'nama_pasangan' => $row[31],
                'jumlah_anak' => $row[32],
                'keterangan' => $row[33],

                'status' => true,
                'avatar' => 'default.png',
            ]);
        }
    }
}
