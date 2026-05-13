<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OldQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Question::truncate();

        // Opsi Skala Likert 0-3
        $options = json_encode([
            '0' => 'Tidak pernah sama sekali',
            '1' => 'Beberapa hari',
            '2' => 'Lebih dari separuh waktu',
            '3' => 'Hampir setiap hari'
        ]);

        // ==========================================
        // 1. Instrumen Depresi (PHQ-9)
        // Parameter: Frekuensi gejala yang dirasakan pengguna dalam 2 minggu terakhir.
        // ==========================================
        $depressionQs = [
            'Kurang minat atau kesenangan dalam melakukan sesuatu', 
            'Merasa sedih, tertekan, atau putus asa', 
            'Sulit tidur, terbangun di tengah malam, atau terlalu banyak tidur',
            'Merasa lelah atau kurang bertenaga',
            'Kurang nafsu makan atau makan berlebihan',
            'Merasa buruk tentang diri sendiri atau merasa gagal atau mengecewakan diri sendiri/keluarga',
            'Sulit berkonsentrasi pada sesuatu, seperti membaca koran atau menonton televisi',
            'Bergerak/berbicara sangat lambat, atau sebaliknya merasa gelisah/tidak bisa diam',
            'Memiliki pikiran bahwa lebih baik mati atau ingin melukai diri sendiri'
        ];

        foreach ($depressionQs as $idx => $text) {
            Question::create([
                'type' => 'depression',
                'question_text' => $text,
                'options' => $options,
                'correct_answer' => null, // Tidak ada jawaban 'benar', hanya akumulasi skor
                'order' => $idx + 1
            ]);
        }

        // ==========================================
        // 2. Instrumen Kecemasan (GAD-7)
        // Parameter: Tingkat kecemasan dan kekhawatiran dalam 2 minggu terakhir.
        // ==========================================
        $anxietyQs = [
            'Merasa gugup, cemas, atau tegang', // Contoh 1
            'Tidak mampu menghentikan atau mengendalikan kekhawatiran', // Contoh 2
            'Terlalu mengkhawatirkan berbagai hal',
            'Kesulitan untuk bersantai',
            'Sangat gelisah sehingga sulit untuk duduk diam',
            'Menjadi mudah kesal atau gampang marah',
            'Merasa takut seolah-olah sesuatu yang buruk akan terjadi'
        ];

        foreach ($anxietyQs as $idx => $text) {
            Question::create([
                'type' => 'anxiety',
                'question_text' => $text,
                'options' => $options,
                'correct_answer' => null,
                'order' => $idx + 1
            ]);
        }

        // ==========================================
        // 3. Pertanyaan Dampak Fungsional
        // Parameter: Seberapa sulit masalah-masalah tersebut membuat Anda melakukan pekerjaan, dll.
        // ==========================================
        Question::create([
            'type' => 'impact',
            'question_text' => 'Bila Anda mengalami masalah-masalah di atas, seberapa sulit masalah tersebut membuat Anda melakukan pekerjaan, mengurus rumah, atau bergaul dengan orang lain?',
            'options' => json_encode([
                '0' => 'Tidak sulit sama sekali',
                '1' => 'Agak sulit',
                '2' => 'Sangat sulit',
                '3' => 'Sangat sulit sekali'
            ]),
            'correct_answer' => null,
            'order' => 1
        ]);
    }
}
