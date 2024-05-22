<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\Karyawan;
use App\Models\User;
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

            // Map unit_kode to role
            $unitRoles = [
                // 0 Super Admin
                // 1 Admin
                // Teacher
                '1' => 1, // Extracurricular Teacher
                '2' => 2, // Playgroup - Kindergarten
                '3' => 3, // Primary
                '4' => 4, // Junior High School
                '5' => 5, // Senior High School

                '6' => 6, // HRD / Personel
                '7' => 7, // Finance Admin
                '8' => 8, // Librarian
                '9' => 9, // Admission
                // '10' //Security
                // '11' //Suster
                // '12' //Sauber
                // '13' //IT Staff
                '14' => 14, // General Affair
                // '15' => 10, // Cleaner
                // Sales
            ];

            // Create User
            $user = User::create([
                'username' => strtolower(str_replace(' ', '', $row[8])),
                'password' => bcrypt(gmdate('d-m-Y', Date::excelToTimestamp($row[22]))),
                'status' => true
            ]);

            // Map unit_kode to role
            $unitRoles = [
                '1' => 'Extracurricular Teacher',
                '2' => 'Teacher PG-KG',
                '3' => 'Teacher',
                '4' => 'Teacher',
                '5' => 'Teacher',
                '6' => 'HRD',
                '7' => 'Finance',
                '8' => 'Librarian',
                '9' => 'Admission',
                '13' => 'IT',
                '14' => 'General Affair'
            ];

            // Periksa dan tetapkan peran berdasarkan nilai dari $row[3]
            $unitCode = $row[3] ?? null;
            if ($unitCode && in_array($unitCode, ['3', '4', '5'])) {
                $user->assignRole('Teacher');
            } elseif (($unitCode && in_array($unitCode, ['6']))) {
                $user->assignRole(['HRD', 'Personel']);
            } elseif ($unitCode && isset($unitRoles[$unitCode])) {
                $user->assignRole($unitRoles[$unitCode]);
            }

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
