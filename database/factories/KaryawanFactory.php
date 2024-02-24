<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KaryawanFactory extends Factory
{
    protected $model = Karyawan::class;

    public function definition()
    {
        $user = User::factory()->create(['role' => '2']);

        return [
            'user_id' => $user->id,
            'status_karyawan_id' => 1,
            'unit_karyawan_id' => 2,
            'position_karyawan_id' => 1,
            'join_date' => '2022-01-01',
            'resign_date' => null,
            'permanent_date' => '2023-01-01',

            'kode_karyawan' => 'K001',
            'nama_lengkap' => $this->faker->name,
            'nik' => $this->faker->numerify('################'),
            'nomor_akun' => $this->faker->numerify('#########'),
            'nomor_fingerprint' => $this->faker->randomNumber(),

            'nomor_taxpayer' => $this->faker->numerify('#########'),
            'nama_taxpayer' => $this->faker->name,
            'nomor_bpjs_ketenagakerjaan' => $this->faker->numerify('#########'),
            'iuran_bpjs_ketenagakerjaan' => $this->faker->numerify('Rp. ######'),
            'nomor_bpjs_yayasan' => $this->faker->numerify('#########'),
            'nomor_bpjs_pribadi' => $this->faker->numerify('#########'),

            'jenis_kelamin' => 'MALE',
            'agama' => '1',
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date(),
            'alamat' => $this->faker->address,
            'alamat_sekarang' => $this->faker->address,
            'kota' => $this->faker->city,
            'kode_pos' => $this->faker->numerify('#####'),
            'nomor_phone' => $this->faker->phoneNumber,
            'nomor_hp' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'email_sekolah' => $this->faker->unique()->safeEmail,
            'warga_negara' => 'Indonesia',
            'status_pernikahan' => '1',
            'nama_pasangan' => $this->faker->name,
            'jumlah_anak' => '2',
            'keterangan' => $this->faker->text,

            'status' => true,
            'avatar' => 'default.png',
        ];
    }
}
