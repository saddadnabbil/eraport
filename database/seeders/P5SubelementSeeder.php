<?php

namespace Database\Seeders;

use App\Models\P5Subelement;
use Illuminate\Database\Seeder;

class P5SubelementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subelements = [
            // Akhlak beragama
            ['p5_element_id' => 1, 'name' => 'Mengenal dan Mencintai Tuhan Yang Maha Esa', 'description' => 'Mengenalkan konsep tentang Tuhan dan pentingnya cinta kasih kepada-Nya.'],
            ['p5_element_id' => 1, 'name' => 'Pemahaman Agama/Kepercayaan', 'description' => 'Memahami nilai-nilai dan ajaran dalam agama atau kepercayaan yang dianut.'],
            ['p5_element_id' => 1, 'name' => 'Pelaksanaan Ritual Ibadah', 'description' => 'Melaksanakan ritus atau ibadah sesuai dengan ajaran agama atau kepercayaan.'],
            // Akhlak Pribadi
            ['p5_element_id' => 2, 'name' => 'Merawat Diri secara Fisik, Mental, dan Spiritual', 'description' => 'Menjaga kesehatan tubuh, pikiran, dan jiwa dengan baik.'],
            ['p5_element_id' => 2, 'name' => 'Integritas', 'description' => 'Menjunjung tinggi nilai-nilai kejujuran dan keselarasan antara ucapan dan tindakan.'],
            // Akhlak kepada manusia
            ['p5_element_id' => 3, 'name' => 'Mengutamakan persamaan dengan orang lain dan menghargai perbedaan', 'description' => 'Menerima dan menghargai keberagaman individu serta memperlakukan semua orang dengan adil.'],
            ['p5_element_id' => 3, 'name' => 'Berempati kepada orang lain', 'description' => 'Merasakan dan memahami perasaan serta pengalaman orang lain dengan empati dan kepekaan.'],
            // Akhlak kepada alam
            ['p5_element_id' => 4, 'name' => 'Memahami Keterhubungan Ekosistem Bumi', 'description' => 'Mengenal dan memahami keterkaitan antara semua makhluk hidup dan unsur alam di Bumi.'],
            ['p5_element_id' => 4, 'name' => 'Menjaga Lingkungan Alam Sekitar', 'description' => 'Bertanggung jawab dalam melestarikan dan melindungi lingkungan alam di sekitar kita.'],
            // Akhlak bernegara
            ['p5_element_id' => 5, 'name' => 'Melaksanakan Hak dan Kewajiban sebagai Warga Negara Indonesia', 'description' => 'Mematuhi undang-undang dan peraturan serta berperan aktif dalam pembangunan negara.'],
            // Mengenal dan menghargai budaya
            ['p5_element_id' => 6, 'name' => 'Mendalami budaya dan identitas budaya', 'description' => 'Belajar tentang nilai-nilai, tradisi, dan kebudayaan dari berbagai kelompok masyarakat.'],
            ['p5_element_id' => 6, 'name' => 'Mengeksplorasi dan membandingkan pengetahuan budaya, kepercayaan, serta praktiknya', 'description' => 'Menelusuri perbedaan dan persamaan antara berbagai kebudayaan serta menghargai keragaman tersebut.'],
            ['p5_element_id' => 6, 'name' => 'Menumbuhkan rasa menghormati terhadap keanekaragaman budaya', 'description' => 'Menghargai perbedaan dan merespons dengan sikap saling menghormati terhadap keanekaragaman budaya.'],
            // Komunikasi dan interaksi antar budaya
            ['p5_element_id' => 7, 'name' => 'Berkomunikasi antar budaya', 'description' => 'Berinteraksi dengan orang dari latar belakang budaya yang berbeda dengan saling memahami dan menghormati.'],
            ['p5_element_id' => 7, 'name' => 'Mempertimbangkan dan menumbuhkan berbagai perspektif', 'description' => 'Menghargai sudut pandang dan pengalaman hidup yang berbeda dalam berkomunikasi dan berinteraksi.'],
            ['p5_element_id' => 7, 'name' => 'Menghilangkan stereotip dan prasangka', 'description' => 'Menghindari penilaian dan pandangan negatif yang didasarkan pada stereotip atau prasangka terhadap budaya lain.'],
            ['p5_element_id' => 7, 'name' => 'Menyelaraskan perbedaan budaya', 'description' => 'Menciptakan hubungan yang harmonis dan saling menguntungkan antara berbagai budaya.'],
            // Refleksi dan bertanggung jawab terhadap pengalaman kebinekaan
            ['p5_element_id' => 8, 'name' => 'Refleksi terhadap pengalaman kebinekaan', 'description' => 'Mengintrospeksi dan mengevaluasi pengalaman serta pembelajaran dari interaksi dengan beragam budaya.'],
            // Berkeadilan Sosial
            ['p5_element_id' => 9, 'name' => 'Aktif membangun masyarakat yang inklusif, adil, dan berkelanjutan', 'description' => 'Berperan dalam memastikan bahwa semua individu memiliki hak yang sama dan kesempatan yang adil dalam masyarakat.'],
            ['p5_element_id' => 9, 'name' => 'Berpartisipasi dalam proses pengambilan keputusan bersama', 'description' => 'Terlibat aktif dalam pembuatan keputusan yang mempengaruhi masyarakat secara keseluruhan.'],
            ['p5_element_id' => 9, 'name' => 'Memahami peran individu dalam demokrasi', 'description' => 'Menyadari pentingnya partisipasi individu dalam proses demokratis untuk mencapai keadilan sosial.'],
            // Kolaborasi
            ['p5_element_id' => 10, 'name' => 'Kerja sama', 'description' => 'Bekerja bersama dengan orang lain untuk mencapai tujuan bersama.'],
            ['p5_element_id' => 10, 'name' => 'Komunikasi untuk mencapai tujuan bersama', 'description' => 'Berinteraksi dan berkomunikasi secara efektif untuk menyatukan usaha dalam mencapai tujuan yang sama.'],
            ['p5_element_id' => 10, 'name' => 'Saling-ketergantungan positif', 'description' => 'Membangun hubungan saling menguntungkan di mana setiap pihak bergantung satu sama lain untuk mencapai kesuksesan bersama.'],
            ['p5_element_id' => 10, 'name' => 'Koordinasi Sosial', 'description' => 'Menyusun rencana dan mengelola sumber daya bersama untuk mencapai hasil yang diinginkan secara efisien.'],
            // Kepedulian
            ['p5_element_id' => 11, 'name' => 'Tanggap terhadap lingkungan sosial', 'description' => 'Mengenali dan merespons kebutuhan serta masalah yang dihadapi oleh masyarakat sekitar.'],
            ['p5_element_id' => 11, 'name' => 'Persepsi sosial', 'description' => 'Memahami dinamika sosial dan persepsi individu terhadap lingkungan sosialnya.'],
            // Berbagi
            ['p5_element_id' => 12, 'name' => 'Berbagi', 'description' => 'Memberikan dukungan, pengetahuan, atau sumber daya kepada orang lain tanpa mengharapkan imbalan yang sepadan.'],
            // Pemahaman diri dan situasi yang dihadapi
            ['p5_element_id' => 13, 'name' => 'Mengenali kualitas dan minat diri serta tantangan yang dihadapi', 'description' => 'Mengetahui kekuatan, kelemahan, minat, dan tantangan pribadi untuk mengembangkan diri secara optimal.'],
            ['p5_element_id' => 13, 'name' => 'Mengembangkan refleksi diri', 'description' => 'Memeriksa dan memahami reaksi dan respons pribadi terhadap situasi dan pengalaman yang dialami.'],
            // Regulasi Diri
            ['p5_element_id' => 14, 'name' => 'Regulasi emosi', 'description' => 'Mengelola dan mengendalikan emosi secara sehat dan konstruktif.'],
            ['p5_element_id' => 14, 'name' => 'Penetapan tujuan belajar, prestasi, dan pengembangan diri serta rencana strategis untuk mencapainya', 'description' => 'Menetapkan target yang jelas untuk pencapaian pribadi dan merancang rencana untuk mencapainya.'],
            ['p5_element_id' => 14, 'name' => 'Menunjukkan inisiatif dan bekerja secara mandiri', 'description' => 'Bekerja secara proaktif dan independen untuk mencapai tujuan pribadi.'],
            ['p5_element_id' => 14, 'name' => 'Mengembangkan pengendalian dan disiplin diri', 'description' => 'Meningkatkan kemampuan untuk mengatur perilaku dan tanggung jawab pribadi secara efektif.'],
            ['p5_element_id' => 14, 'name' => 'Percaya diri, tangguh (resilient), dan adaptif', 'description' => 'Memiliki keyakinan diri yang kuat, mampu mengatasi rintangan, dan menyesuaikan diri dengan perubahan.'],
            // Memperoleh dan memproses informasi dan gagasan
            ['p5_element_id' => 15, 'name' => 'Mengajukan pertanyaan', 'description' => 'Menggali informasi lebih lanjut dengan bertanya dan mencari jawaban atas pertanyaan yang muncul.'],
            ['p5_element_id' => 15, 'name' => 'Mengidentifikasi, mengklarifikasi, dan mengolah informasi dan gagasan', 'description' => 'Menganalisis, memahami, dan mengelola informasi serta gagasan dengan baik.'],
            // Menganalisis dan mengevaluasi penalaran dan prosedurnya
            ['p5_element_id' => 16, 'name' => 'Elemen menganalisis dan mengevaluasi penalaran dan prosedurnya', 'description' => 'Mengkritisi dan mengevaluasi secara kritis proses berpikir dan langkah-langkah yang diambil dalam mencapai suatu kesimpulan atau tujuan.'],
            // Refleksi pemikiran dan proses berpikir
            ['p5_element_id' => 17, 'name' => 'Merefleksi dan mengevaluasi pemikirannya sendiri', 'description' => 'Mengintrospeksi dan menilai secara kritis pemikiran serta proses berpikir pribadi.'],
            // Menghasilkan gagasan yang orisinal
            ['p5_element_id' => 18, 'name' => 'Menghasilkan gagasan yang orisinal', 'description' => 'Menciptakan ide-ide baru atau solusi yang kreatif dan inovatif.'],
            // Mengeksplorasi gagasan yang orisinal
            ['p5_element_id' => 19, 'name' => 'Mengeksplorasi gagasan yang orisinal', 'description' => 'Mengembangkan dan menyelidiki ide-ide baru atau konsep yang belum pernah dipikirkan sebelumnya.'],
            // Memiliki keluwesan berpikir dalam mencari alternatif solusi permasalahan
            ['p5_element_id' => 20, 'name' => 'Memiliki keluwesan berpikir dalam mencari alternatif solusi permasalahan', 'description' => 'Berpikir kreatif dan fleksibel dalam menemukan berbagai solusi untuk masalah yang dihadapi.'],
        ];

        // Masukkan data ke dalam tabel p5_subelements
        foreach ($subelements as $subelement) {
            P5Subelement::create($subelement);
        }
    }
}
