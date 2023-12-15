<?php

namespace Database\Factories;


use App\User;
use App\Siswa;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'user_id' => $this->faker->unique()->numberBetween(4, 8),
            'kelas_id' => $this->faker->numberBetween(1, 2),
            'tingkatan_id' => $this->faker->numberBetween(1, 2),
            'jenis_pendaftaran' => $this->faker->randomElement(['1', '2']),
            'nis' => $this->faker->unique()->numerify('##########'),
            'nisn' => $this->faker->unique()->numerify('##########'),
            'nama_lengkap' => $this->faker->name,
            'nama_panggilan' => $this->faker->firstName,
            'nik' => $this->faker->unique()->numerify('################'),
            'email' => $this->faker->unique()->safeEmail,
            'nomor_hp' => $this->faker->numerify('###########'),
            'jenis_kelamin' => $this->faker->randomElement(['Male', 'Female']),
            'blood_type' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'agama' => $this->faker->randomElement(['1', '2', '3', '4', '5', '6', '7']),
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date,
            'anak_ke' => $this->faker->numerify('##'),
            'jml_saudara_kandung' => $this->faker->numerify('##'),
            'warga_negara' => $this->faker->countryCode,
            'alamat' => $this->faker->address,
            'kota' => $this->faker->city,
            'kode_pos' => $this->faker->numerify('#####'),
            'jarak_rumah_ke_sekolah' => $this->faker->numberBetween(1, 10),
            'status_dalam_keluarga' => $this->faker->randomElement(['1', '2', '3']),
            'tinggal_bersama' => $this->faker->randomElement(['Parents', 'Others']),
            'transportasi' => $this->faker->word,
            'nama_ayah' => $this->faker->name('male'),
            'nama_ibu' => $this->faker->name('female'),
            'nama_wali' => $this->faker->name,
            'nik_ayah' => $this->faker->unique()->numerify('################'),
            'nik_ibu' => $this->faker->unique()->numerify('################'),
            'nik_wali' => $this->faker->unique()->numerify('################'),
            'email_ayah' => $this->faker->unique()->safeEmail,
            'email_ibu' => $this->faker->unique()->safeEmail,
            'email_wali' => $this->faker->unique()->safeEmail,
            'nomor_hp_ayah' => $this->faker->numerify('###########'),
            'nomor_hp_ibu' => $this->faker->numerify('###########'),
            'nomor_hp_wali' => $this->faker->numerify('###########'),
            'pekerjaan_ayah' => $this->faker->word,
            'pekerjaan_ibu' => $this->faker->word,
            'pekerjaan_wali' => $this->faker->word,
            'tinggi_badan' => $this->faker->numberBetween(150, 190),
            'berat_badan' => $this->faker->numberBetween(40, 100),
            'spesial_treatment' => $this->faker->word,
            'note_kesehatan' => $this->faker->sentence,
            'file_document_kesehatan' => $this->faker->word,
            'file_list_pertanyaan' => $this->faker->word,
            'tanggal_masuk_sekolah_lama' => $this->faker->date,
            'tanggal_keluar_sekolah_lama' => $this->faker->date,
            'nama_sekolah_lama' => $this->faker->word,
            'alamat_lama' => $this->faker->address,
            'no_sttb' => $this->faker->word,
            'nem' => $this->faker->randomFloat(2, 1, 10),
            'file_dokument_sekolah_lama' => $this->faker->word,
            'avatar' => 'default.png',
            'status' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
