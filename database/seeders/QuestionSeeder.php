<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\ScreeningResponse;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ScreeningResponse::truncate();
        Question::truncate();

        // Opsi Skala Likert 1-4
        $options = json_encode([
            '1' => 'Sangat Tidak Sesuai',
            '2' => 'Tidak Sesuai',
            '3' => 'Sesuai',
            '4' => 'Sangat Sesuai'
        ]);

        $order = 1;

        // ==========================================
        // 1. Kuesioner Depresi
        // ==========================================
        $depresiSubtypes = [
            'Depresi Emosional' => [
                'Saya merasa sedih hampir setiap hari',
                'Saya merasa tidak berharga',
                'Saya sering merasa bersalah tanpa alasan jelas',
                'Saya merasa kehilangan harapan',
            ],
            'Pikiran Negatif' => [
                'Saya sering menyalahkan diri sendiri',
                'Saya merasa gagal dalam hidup',
                'Saya sulit berkonsentrasi',
                'Saya merasa ketakutan dengan masa depan yang suram',
            ],
            'Somatik' => [
                'Saya merasa lelah tanpa sebab yang jelas',
                'Pola tidur saya terganggu',
                'Nafsu makan saya berubah',
                'Saya kurang berenergi untuk aktivitas',
            ],
            'Menarik Diri' => [
                'Saya menghindari interaksi sosial',
                'Saya kehilangan minat pada aktivitas yang dulu disukai',
                'Saya lebih memilih menyendiri',
                'Saya sulit melakukan aktivitas sehari-hari',
            ],
        ];

        foreach ($depresiSubtypes as $subtype => $questions) {
            foreach ($questions as $text) {
                Question::create([
                    'type' => 'depression',
                    'subtype' => $subtype,
                    'question_text' => $text,
                    'options' => $options,
                    'correct_answer' => null,
                    'order' => $order++
                ]);
            }
        }

        // ==========================================
        // 2. Kuesioner Ansietas
        // ==========================================
        $ansietasSubtypes = [
            'Konflik antara Id dan Ego' => [
                'Saya merasa gelisah tanpa alasan yang jelas',
                'Saya takut kehilangan kontrol terhadap diri sendiri',
                'Saya sering merasa cemas terhadap pikiran saya sendiri',
                'Saya merasa sulit menenangkan diri',
            ],
            'Konflik Ego dan Superego' => [
                'Saya merasa bersalah ketika melakukan kesalahan kecil',
                'Saya takut dianggap buruk oleh orang lain',
                'Saya khawatir melanggar aturan atau norma',
                'Saya sering menyalahkan diri sendiri',
            ],
            'Ketakutan terhadap ancaman nyata' => [
                'Saya mudah cemas terhadap masalah kehidupan sehari-hari',
                'Saya takut menghadapi situasi yang menekan',
                'Saya merasa tegang saat menghadapi tuntutan',
                'Saya khawatir terhadap masa depan',
            ],
            'Respon ego terhadap kecemasan' => [
                'Saya menyangkal masalah yang membuat saya cemas',
                'Saya menghindari situasi yang membuat saya tertekan',
                'Saya menyalahkan orang lain ketika merasa tertekan',
                'Saya mencari alasan untuk membenarkan perilaku saya',
            ],
        ];

        foreach ($ansietasSubtypes as $subtype => $questions) {
            foreach ($questions as $text) {
                Question::create([
                    'type' => 'anxiety',
                    'subtype' => $subtype,
                    'question_text' => $text,
                    'options' => $options,
                    'correct_answer' => null,
                    'order' => $order++
                ]);
            }
        }

        // ==========================================
        // 3. Pertanyaan Dampak Fungsional
        // ==========================================
        Question::create([
            'type' => 'impact',
            'subtype' => null,
            'question_text' => 'Bila Anda mengalami masalah-masalah di atas, seberapa sulit masalah tersebut membuat Anda melakukan pekerjaan, mengurus rumah, atau bergaul dengan orang lain?',
            'options' => json_encode([
                '0' => 'Tidak sulit sama sekali',
                '1' => 'Agak sulit',
                '2' => 'Sangat sulit',
                '3' => 'Sangat sulit sekali'
            ]),
            'correct_answer' => null,
            'order' => $order++
        ]);
    }
}
