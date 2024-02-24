<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition()
    {

        $user = User::factory()->create(['role' => '3']);
        $kelas = Kelas::inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'kelas_id' => $kelas->id,
            'tingkatan_id' => function (array $attributes) {
                return Kelas::find($attributes['kelas_id'])->tingkatan_id; // Mengambil tingkatan_id dari Kelas
            },
            'jurusan_id' => function (array $attributes) {
                return Kelas::find($attributes['kelas_id'])->jurusan_id;
            },
            'jenis_pendaftaran' => '1',
            'tahun_masuk' => $this->faker->year,
            'semester_masuk' => $this->faker->randomElement(['1', '2']),
            'kelas_masuk' => 'PA1',

            'nis' => $this->faker->numerify('##########'),
            'nisn' => $this->faker->numerify('##########'),
            'nama_lengkap' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'nama_panggilan' => 'Dummy ' . $this->faker->firstName,
            'nik' => $this->faker->numerify('################'),
            'jenis_kelamin' => $this->faker->randomElement(['MALE', 'FEMALE']),
            'blood_type' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'agama' => $this->faker->randomElement(['1', '2', '3', '4', '5', '6', '7']),
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date(),
            'anak_ke' => $this->faker->numerify('##'),
            'jml_saudara_kandung' => $this->faker->numerify('##'),
            'warga_negara' => 'ID',
            'pas_photo' => 'default.png',

            'alamat' => $this->faker->address,
            'kota' => $this->faker->city,
            'kode_pos' => $this->faker->numerify('#####'),
            'jarak_rumah_ke_sekolah' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'email' => $this->faker->unique()->safeEmail,
            'email_parent' => $this->faker->unique()->safeEmail,
            'nomor_hp' => $this->faker->numerify('#############'),
            'tinggal_bersama' => $this->faker->randomElement(['Parents', 'Others']),
            'transportasi' => $this->faker->randomElement(['Car', 'Motorcycle', 'Bicycle']),

            'nik_ayah' => $this->faker->numerify('################'),
            'nama_ayah' => $this->faker->name,
            'tempat_lahir_ayah' => $this->faker->city,
            'tanggal_lahir_ayah' => $this->faker->date(),
            'alamat_ayah' => $this->faker->address,
            'nomor_hp_ayah' => $this->faker->numerify('#############'),
            'agama_ayah' => $this->faker->randomElement(['1', '2', '3', '4', '5', '6', '7']),
            'kota_ayah' => $this->faker->city,
            'pendidikan_terakhir_ayah' => $this->faker->randomElement(['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3']),
            'pekerjaan_ayah' => $this->faker->jobTitle,
            'penghasil_ayah' => $this->faker->randomElement(['0 - 1 Juta', '1 - 2 Juta', '2 - 5 Juta', '> 5 Juta']),

            'nik_ibu' => $this->faker->numerify('################'),
            'nama_ibu' => $this->faker->name,
            'tempat_lahir_ibu' => $this->faker->city,
            'tanggal_lahir_ibu' => $this->faker->date(),
            'alamat_ibu' => $this->faker->address,
            'nomor_hp_ibu' => $this->faker->numerify('#############'),
            'agama_ibu' => $this->faker->randomElement(['1', '2', '3', '4', '5', '6', '7']),
            'kota_ibu' => $this->faker->city,
            'pendidikan_terakhir_ibu' => $this->faker->randomElement(['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3']),
            'pekerjaan_ibu' => $this->faker->jobTitle,
            'penghasil_ibu' => $this->faker->randomElement(['0 - 1 Juta', '1 - 2 Juta', '2 - 5 Juta', '> 5 Juta']),

            'nik_wali' => $this->faker->numerify('################'),
            'nama_wali' => $this->faker->name,
            'tempat_lahir_wali' => $this->faker->city,
            'tanggal_lahir_wali' => $this->faker->date(),
            'alamat_wali' => $this->faker->address,
            'nomor_hp_wali' => $this->faker->numerify('#############'),
            'agama_wali' => $this->faker->randomElement(['1', '2', '3', '4', '5', '6', '7']),
            'kota_wali' => $this->faker->city,
            'pendidikan_terakhir_wali' => $this->faker->randomElement(['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3']),
            'pekerjaan_wali' => $this->faker->jobTitle,
            'penghasil_wali' => $this->faker->randomElement(['0 - 1 Juta', '1 - 2 Juta', '2 - 5 Juta', '> 5 Juta']),

            'tinggi_badan' => $this->faker->numerify('###'),
            'berat_badan' => $this->faker->numerify('##'),
            'spesial_treatment' => $this->faker->randomElement(['None', 'Yes']),
            'note_kesehatan' => $this->faker->sentence,
            'file_document_kesehatan' => 'health_document.pdf',
            'file_list_pertanyaan' => 'questionnaire.pdf',

            'tanggal_masuk_sekolah_lama' => $this->faker->date(),
            'tanggal_keluar_sekolah_lama' => $this->faker->date(),
            'nama_sekolah_lama' => $this->faker->company,
            'alamat_sekolah_lama' => $this->faker->address,
            'prestasi_sekolah_lama' => $this->faker->sentence,
            'tahun_prestasi_sekolah_lama' => $this->faker->year,
            'sertifikat_number_sekolah_lama' => $this->faker->numerify('######'),
            'no_sttb' => $this->faker->numerify('######'),
            'nem' => $this->faker->randomFloat(2, 0, 10),
            'file_dokument_sekolah_lama' => 'previous_school_document.pdf',

            'avatar' => 'default.png',
            'status' => $this->faker->randomElement(['1']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
