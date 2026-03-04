<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EducationalMaterial;
use Illuminate\Support\Str;

class EducationalMaterialSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Masalah Kesehatan Gigi (Gingivitis)
        EducationalMaterial::create([
            'title' => 'Masalah Kesehatan Gigi & Gingivitis',
            'slug'  => 'masalah-kesehatan-gigi-gingivitis',
            'category' => 'Masalah Gigi',
            'thumbnail' => 'gingivitis.jpg', // Pastikan file gambar ada di folder public/images/
            'video_url' => null,
            'content' => '
                <p>Ibu hamil merupakan kelompok rentan terhadap gangguan kesehatan gigi dan mulut akibat perubahan hormonal yang memengaruhi anatomi, fisiologi, dan metabolisme tubuh. Perubahan hormon, pola makan, serta gejala seperti mual dan muntah dapat memengaruhi kondisi rongga mulut.</p>

                <h3>Apa itu Gingivitis?</h3>
                <p>Salah satu penyebab utama gangguan pada gusi adalah plak gigi (lapisan tipis kuman dan sisa makanan). Jika tidak dibersihkan, plak mengeras menjadi karang gigi dan menyebabkan peradangan gusi atau gingivitis.</p>

                <h3>Tanda-tanda Radang Gusi pada Ibu Hamil:</h3>
                <ul>
                    <li><strong>Perubahan warna gusi:</strong> Gusi menjadi merah tua atau keunguan.</li>
                    <li><strong>Gusi bengkak dan lunak:</strong> Mudah berdarah saat menyikat gigi.</li>
                    <li><strong>Nyeri atau sensitif:</strong> Rasa tidak nyaman di sekitar gigi.</li>
                    <li><strong>Perubahan bentuk:</strong> Gusi menebal atau menonjol.</li>
                </ul>

                <h3>Jenis-Jenis Gingivitis:</h3>
                <ul>
                    <li><strong>Pregnancy Gingivitis:</strong> Terjadi selama kehamilan (trimester 2-3) akibat perubahan hormonal. Gusi bengkak, merah, dan mudah berdarah.</li>
                    <li><strong>Gingivitis Marginalis Kronis:</strong> Peradangan tepi gusi akibat penumpukan plak.</li>
                </ul>
            '
        ]);

        // 2. Kehamilan & Perubahan Hormonal
        EducationalMaterial::create([
            'title' => 'Mengenal Kehamilan & Perubahan Hormon',
            'slug'  => 'mengenal-kehamilan-perubahan-hormon',
            'category' => 'Kehamilan',
            'thumbnail' => 'pregnancy.jpg',
            'video_url' => null,
            'content' => '
                <p>Kehamilan adalah suatu proses alamiah yang melibatkan perubahan fungsi tubuh, bentuk tubuh, dan perubahan hormon. Ibu hamil mengalami peningkatan hormon seks wanita (estrogen 10x lipat dan progesteron 30x lipat) untuk kebutuhan ibu dan janin.</p>

                <h3>Tahapan Kehamilan (Trimester):</h3>
                <ul>
                    <li><strong>Trimester 1:</strong> Ibu hamil merasa lesu, mual, dan kadang muntah (morning sickness).</li>
                    <li><strong>Trimester 2:</strong> Pembesaran perut mulai terlihat, gerakan janin dirasakan, mual muntah menghilang.</li>
                    <li><strong>Trimester 3:</strong> Pembesaran perut dan gerakan janin semakin jelas.</li>
                </ul>

                <h3>Alur Pemeriksaan di Puskesmas:</h3>
                <p>Registrasi -> Pemeriksaan Bidan -> Laboratorium -> Konsultasi Umum -> <strong>Konsultasi & Pemeriksaan Gigi</strong> -> Konsultasi Gizi -> Pengambilan Obat/Vitamin.</p>
            '
        ]);

        // 3. Penyakit Gigi & Dampaknya pada Kehamilan
        EducationalMaterial::create([
            'title' => 'Penyakit Gigi & Dampak pada Janin',
            'slug'  => 'penyakit-gigi-dampak-janin',
            'category' => 'Masalah Gigi',
            'thumbnail' => 'impact.jpg',
            'video_url' => null,
            'content' => '
                <h3>Penyakit yang Sering Muncul:</h3>
                <ol>
                    <li><strong>Gingivitis (Radang Gusi):</strong> Gusi bengkak dan kemerahan akibat reaksi tubuh terhadap kotoran/plak di mulut.</li>
                    <li><strong>Tumor Gusi (Epulis Gravidarum):</strong> Benjolan pada gusi (biasanya rahang atas) berwarna merah keunguan, mudah berdarah. Disebabkan iritasi kronis dan perubahan hormon.</li>
                    <li><strong>Gigi Berlubang (Karies):</strong> Akibat air ludah yang lebih asam, sering muntah, dan konsumsi makanan manis berlebih.</li>
                </ol>

                <h3>Dampak Sakit Gigi Terhadap Kehamilan:</h3>
                <ul>
                    <li>Kuman dari gigi berlubang dapat masuk ke aliran darah dan mencapai janin.</li>
                    <li>Ibu malas makan karena sakit gigi -> asupan gizi janin berkurang -> risiko <strong>Berat Badan Lahir Rendah (BBLR)</strong>.</li>
                    <li>Peningkatan hormon prostaglandin akibat radang dapat memicu kontraksi rahim -> risiko <strong>Keguguran</strong> atau <strong>Bayi Lahir Prematur</strong>.</li>
                </ul>
            '
        ]);

        // 4. Panduan Perawatan Gigi (Waktu Aman)
        EducationalMaterial::create([
            'title' => 'Waktu Aman Perawatan Gigi',
            'slug'  => 'waktu-aman-perawatan-gigi',
            'category' => 'Perawatan',
            'thumbnail' => 'dentist.jpg',
            'video_url' => null,
            'content' => '
                <h3>Panduan Perawatan Gigi per Trimester:</h3>
                <ul>
                    <li><strong>Trimester 1:</strong> Hindari perawatan dental (masa pembentukan organ janin).</li>
                    <li><strong>Trimester 2:</strong> Waktu paling aman. Dapat dilakukan perawatan dental rutin.</li>
                    <li><strong>Trimester 3:</strong> Hanya untuk perawatan darurat dan pengobatan infeksi.</li>
                </ul>

                <h3>Catatan Penting:</h3>
                <ul>
                    <li><strong>Radiograf (Rontgen):</strong> Sebaiknya dihindari. Jika terpaksa, HARUS menggunakan Apron Proteksi.</li>
                    <li><strong>Obat-obatan Aman:</strong> Penicillin, Erythomycin, Cephalosphorin, Clindamycin (Sesuai resep dokter).</li>
                </ul>
            '
        ]);

        // 5. Cara Menyikat Gigi & Pencegahan (VIDEO)
        EducationalMaterial::create([
            'title' => 'Cara Menyikat Gigi & Pencegahan',
            'slug'  => 'cara-menyikat-gigi-pencegahan',
            'category' => 'Pencegahan',
            'thumbnail' => 'brushing.jpg',
            'video_url' => 'https://www.youtube.com/embed/AD41DqG3gXI', // Link dari file MATERI [cite: 207]
            'content' => '
                <h3>Langkah Pencegahan:</h3>
                <ol>
                    <li>Menyikat gigi dengan benar 2x sehari (Pagi setelah sarapan & Malam sebelum tidur).</li>
                    <li>Minum air putih setelah muntah untuk menetralkan asam.</li>
                    <li>Gunakan pasta gigi ber-Fluoride.</li>
                    <li>Gunakan benang gigi (dental floss) untuk sela-sela gigi.</li>
                    <li>Gunakan obat kumur antiseptik (non-alkohol).</li>
                </ol>

                <h3>Cara Menyikat Gigi yang Benar:</h3>
                <ul>
                    <li>Pilih sikat gigi berbulu lembut.</li>
                    <li>Oleskan pasta sebesar biji jagung.</li>
                    <li>Sikat membentuk sudut 45 derajat dari arah gusi ke gigi.</li>
                    <li>Sikat seluruh permukaan: bagian luar, dalam, geraham, dan lidah.</li>
                    <li>Durasi menyikat gigi sekitar 2 menit.</li>
                </ul>
                <p><em>Lihat video di atas untuk panduan visual.</em></p>
            '
        ]);

        // 6. Nutrisi Ibu Hamil
        EducationalMaterial::create([
            'title' => 'Nutrisi Sehat untuk Gigi & Janin',
            'slug'  => 'nutrisi-sehat-ibu-hamil',
            'category' => 'Nutrisi',
            'thumbnail' => 'nutrition.jpg',
            'video_url' => null,
            'content' => '
                <p>Selama masa kehamilan, tubuh ibu membutuhkan gizi seimbang untuk mendukung pertumbuhan janin dan kesehatan ibu.</p>

                <h3>Makanan yang Disarankan:</h3>
                <ul>
                    <li><strong>Sayuran Hijau (Bayam, Brokoli):</strong> Sumber asam folat, zat besi, dan kalsium.</li>
                    <li><strong>Buah-buahan (Jeruk, Pisang, Alpukat):</strong> Vitamin C untuk daya tahan tubuh dan serat.</li>
                    <li><strong>Susu & Produk Olahan (Yogurt, Keju):</strong> Kalsium dan Vitamin D untuk pembentukan tulang dan gigi janin.</li>
                    <li><strong>Protein (Telur, Ikan, Ayam, Tahu/Tempe):</strong> Pembentukan sel janin.</li>
                    <li><strong>Air Putih:</strong> 8-10 gelas per hari untuk mencegah dehidrasi.</li>
                </ul>

                <h3>Makanan yang Harus Dihindari:</h3>
                <ul>
                    <li>Makanan mentah atau setengah matang (sushi, telur mentah).</li>
                    <li>Makanan tinggi gula dan lengket (permen, coklat berlebih).</li>
                    <li>Ikan dengan kadar merkuri tinggi (Hiu, Tongkol besar).</li>
                    <li>Kafein berlebihan.</li>
                </ul>
            '
        ]);
    }
}
