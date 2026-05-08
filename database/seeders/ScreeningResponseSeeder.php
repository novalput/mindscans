<?php

namespace Database\Seeders;

use App\Models\ScreeningResponse;
use Illuminate\Database\Seeder;

class ScreeningResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ScreeningResponse::create([
            'user_id' => 2, // Ahmad Muzakki
            'score' => 23,
            'category' => 'Depresi: Sedang (Moderate) | Kecemasan: Ringan (Mild) [! RISIKO TINGGI !]',
            'answers_detail' => json_decode('{"depression":{"score":14,"category":"Sedang (Moderate)","recommendation":"Disarankan berkonsultasi dengan konselor atau psikolog.","high_risk_trigger":true,"detail":{"1":1,"2":1,"3":2,"4":2,"5":2,"6":2,"7":1,"8":2,"9":1}},"anxiety":{"score":9,"category":"Ringan (Mild)","recommendation":"Edukasi mandiri, meditasi, dan pemantauan berkala.","detail":{"10":1,"11":2,"12":1,"13":1,"14":2,"15":1,"16":1}},"impact":{"score":1,"text_answer":"Agak sulit"}}', true),
            'created_at' => '2026-03-06 06:42:21',
            'updated_at' => '2026-03-06 06:42:21',
        ]);

        ScreeningResponse::create([
            'user_id' => 5, // Alif Najmi
            'score' => 8,
            'category' => 'Depresi: Ringan (Mild) | Kecemasan: Minimal/Normal ',
            'answers_detail' => json_decode('{"depression":{"score":7,"category":"Ringan (Mild)","recommendation":"Edukasi mandiri, meditasi, dan pemantauan berkala.","high_risk_trigger":false,"detail":{"1":1,"2":2,"3":2,"4":1,"5":0,"6":1,"7":0,"8":0,"9":0}},"anxiety":{"score":1,"category":"Minimal/Normal","recommendation":"Menjaga gaya hidup sehat dan istirahat cukup.","detail":{"10":1,"11":0,"12":0,"13":0,"14":0,"15":0,"16":0}},"impact":{"score":0,"text_answer":"Tidak sulit sama sekali"}}', true),
            'created_at' => '2026-03-11 02:14:03',
            'updated_at' => '2026-03-11 02:14:03',
        ]);

        ScreeningResponse::create([
            'user_id' => 2, // Ahmad Muzakki
            'score' => 8,
            'category' => 'Depresi: Ringan (Mild) | Kecemasan: Minimal/Normal ',
            'answers_detail' => json_decode('{"depression":{"score":8,"category":"Ringan (Mild)","recommendation":"Edukasi mandiri, meditasi, dan pemantauan berkala.","high_risk_trigger":false,"detail":{"1":1,"2":1,"3":1,"4":1,"5":1,"6":1,"7":1,"8":1,"9":0}},"anxiety":{"score":0,"category":"Minimal/Normal","recommendation":"Menjaga gaya hidup sehat dan istirahat cukup.","detail":{"10":0,"11":0,"12":0,"13":0,"14":0,"15":0,"16":0}},"impact":{"score":1,"text_answer":"Agak sulit"}}', true),
            'created_at' => '2026-03-11 02:20:23',
            'updated_at' => '2026-03-11 02:20:23',
        ]);
    }
}
