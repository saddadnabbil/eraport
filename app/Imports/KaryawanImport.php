<?php

namespace App\Imports;

use App\Guru;
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
                'username' => strtolower(str_replace(' ', '', $row[8])),
                'password' => bcrypt(gmdate('d-m-Y', Date::excelToTimestamp($row[22]))),
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
                'join_date' => $row[5] ? gmdate('Y-m-d', Date::excelToTimestamp($row[5])) : null,
                'resign_date' => $row[6] ? gmdate('Y-m-d', Date::excelToTimestamp($row[6])) : null,
                'permanent_date' => $row[7] ? gmdate('Y-m-d', Date::excelToTimestamp($row[7])) : null,

                'kode_karyawan' => $row[8],
                'nama_lengkap' => strtoupper($row[9]),
                'nik' => $row[10],
                'nomor_akun' => $row[11],
                'nomor_fingerprint' => $row[12],

                'nomor_taxpayer' => $row[13],
                'nama_taxpayer' => $row[14],
                'nomor_bpjs_ketenagakerjaan' => $row[15],
                'iuran_bpjs_ketenagakerjaan' => $row[16],
                'nomor_bpjs_yayasan' => $row[17],
                'nomor_bpjs_pribadi' => $row[18],

                'jenis_kelamin' => strtoupper($row[19]),
                'agama' => $row[20],
                'tempat_lahir' => $row[21],
                'tanggal_lahir' => $row[22] ? gmdate('Y-m-d', Date::excelToTimestamp($row[22])) : null,
                'alamat' => $row[23],
                'alamat_sekarang' => $row[24],
                'kota' => $row[25],
                'kode_pos' => $row[26],
                'nomor_phone' => $row[27],
                'nomor_hp' => $row[28],
                'email' => $row[29],
                'email_sekolah' => $row[30],
                'warga_negara' => $row[31],
                'status_pernikahan' => $row[32],
                'nama_pasangan' => $row[33],
                'jumlah_anak' => $row[34],
                'keterangan' => $row[35],

                'avatar' => 'default.png',
            ]);


            if ($row[3] == 1 || $row[3] == 2 || $row[3] == 3 || $row[3] == 4 || $row[3] == 5) {
                Guru::create([
                    'karyawan_id' => $user->karyawan->id
                ]);
            }
        }
    }
}
