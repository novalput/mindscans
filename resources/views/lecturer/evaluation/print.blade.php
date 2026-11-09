<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Medis - {{ $student->name }}</title>
    {{-- Tailwind via CDN (Abaikan warning prod jika hanya untuk internal/skripsi) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none;
            }

            body {
                padding: 0;
                margin: 0;
                background: white;
                -webkit-print-color-adjust: exact;
            }
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
            font-size: 11px;
        }

        .header-line {
            border-bottom: 3px double black;
        }
    </style>
</head>

<body class="p-10 font-sans text-gray-900 bg-white">
    {{-- Kop Surat --}}
    <div class="text-center mb-6 header-line pb-4">
        <h1 class="text-3xl font-bold uppercase tracking-widest">MindScans</h1>
        <p class="text-sm font-semibold">Laporan Kesehatan Gigi & Mulut Ibu Hamil</p>
        <p class="text-[10px] italic">Automated Gingivitis Detection System</p>
    </div>

    {{-- I. Identitas --}}
    <div class="mb-6">
        <h2 class="font-bold text-xs mb-2 bg-gray-100 px-2 py-1 uppercase border-l-4 border-blue-600">I. Identitas Pasien</h2>
        <table class="border-none w-full">
            <tr class="border-none">
                <td class="w-40 font-bold border-none">Nama Lengkap</td>
                <td class="border-none">: {{ $student->name }}</td>
                <td class="w-40 font-bold border-none">Tanggal Cetak</td>
                <td class="border-none">: {{ now()->format('d/m/Y') }}</td>
            </tr>
            <tr class="border-none">
                <td class="font-bold border-none">Usia Kehamilan</td>
                <td class="border-none">: {{ $student->student->pregnancy_week ?? '-' }} Minggu</td>
                <td class="font-bold border-none">Alamat</td>
                <td class="border-none">: {{ $student->student->address ?? '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- II. Hasil Evaluasi --}}
    <div class="mb-6">
        <h2 class="font-bold text-xs mb-2 bg-gray-100 px-2 py-1 uppercase border-l-4 border-blue-600">II. Hasil Kuesioner</h2>
        <table>
            <thead class="bg-gray-50 text-center">
                <tr>
                    <th>Indikator</th>
                    <th>Skor Awal</th>
                    <th>Skor Akhir</th>
                    <th>Kategori Risiko</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td class="text-left font-semibold italic">Evaluasi Pengetahuan & Gejala</td>
                    <td>{{ $preTest->score ?? 0 }}</td>
                    <td>{{ $postTest->score ?? '-' }}</td>
                    <td>{{ $postTest->category ?? ($preTest->category ?? '-') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- III. Penjelasan MGI (Kamus Ibu Hamil) --}}
    <div class="mb-6">
        <h2 class="font-bold text-xs mb-2 bg-gray-100 px-2 py-1 uppercase border-l-4 border-blue-600">III. Panduan Skor Gusi (MGI)</h2>
        <table>
            <thead class="bg-gray-50">
                <tr>
                    <th class="w-16">Skor</th>
                    <th>Tingkat Peradangan</th>
                    <th>Tanda Klinis pada Ibu Hamil</th>
                </tr>
            </thead>
            <tbody class="text-[10px]">
                <tr>
                    <td class="text-center font-bold">0 - 1</td>
                    <td class="text-green-600 font-bold uppercase">Sehat / Normal</td>
                    <td>Gusi berwarna merah muda (pink), tekstur kencang, dan tidak ada perubahan warna atau bengkak.</td>
                </tr>
                <tr>
                    <td class="text-center font-bold bg-yellow-50">2</td>
                    <td class="text-yellow-600 font-bold uppercase italic">Radang Ringan</td>
                    <td>Terjadi perubahan warna (kemerahan) pada sebagian kecil area gusi, namun belum ada pembengkakan nyata.</td>
                </tr>
                <tr>
                    <td class="text-center font-bold bg-orange-50">3</td>
                    <td class="text-orange-600 font-bold uppercase">Radang Sedang</td>
                    <td>Gusi terlihat merah mengkilap, mulai tampak bengkak (oedema) pada bagian tepi atau sela gigi.</td>
                </tr>
                <tr>
                    <td class="text-center font-bold bg-red-50">4</td>
                    <td class="text-red-600 font-bold uppercase">Radang Berat</td>
                    <td>Peradangan nyata, gusi sangat merah, bengkak besar, dan terdapat kecenderungan berdarah spontan.</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- IV. Analisa Citra AI --}}
    <div class="mb-6">
        <h2 class="font-bold text-xs mb-2 bg-gray-100 px-2 py-1 uppercase border-l-4 border-blue-600">IV. Analisa Deteksi AI</h2>
        <div class="flex gap-4 items-start">
            <div class="w-1/2 border border-black p-1 bg-white">
                @if($latestScan && $latestScan->gingivitis_image)
                {{-- GUNAKAN ASSET() AGAR BROWSER TIDAK BLOCKED LOCAL FILE --}}
                <img src="{{ asset('storage/' . $latestScan->gingivitis_image) }}" class="w-full">
                @else
                <div class="h-40 flex items-center justify-center italic text-gray-400">Gambar tidak tersedia</div>
                @endif
            </div>
            <div class="w-1/2">
                <div class="border border-black p-3 bg-gray-50 h-full">
                    <p class="font-black text-xs uppercase mb-2">Kesimpulan Analisa:</p>
                    <p class="text-sm text-red-600 font-bold mb-4 uppercase">{{ $latestScan->category ?? 'Normal' }}</p>

                    <p class="text-[10px] font-bold mb-1 underline italic">Rincian Area Bermasalah:</p>
                    <ul class="text-[10px] space-y-1">
                        @php $preds = json_decode($latestScan->detection_result ?? '[]', true); @endphp
                        @forelse($preds as $p)
                        <li>- <strong>{{ $p['class'] }}</strong>: Terdeteksi dengan akurasi {{ round($p['confidence'] * 100) }}%</li>
                        @empty
                        <li class="text-green-600">Tidak ditemukan peradangan gusi yang signifikan.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- V. Diagnosa & Rencana Perawatan --}}
    <div class="mb-6">
        <h2 class="font-bold text-xs mb-2 bg-gray-100 px-2 py-1 uppercase border-l-4 border-blue-600">V. Diagnosa & Saran Tenaga Kesehatan</h2>
        <div class="border border-black p-4 bg-white min-h-[100px]">
            <p class="text-[11px] leading-relaxed whitespace-pre-line">
                @if($latestScan && $latestScan->lecturer_advice)
                {{ $latestScan->lecturer_advice }}
                @else
                <span class="text-gray-400 italic">Belum ada saran atau diagnosa manual yang diinputkan oleh tenaga kesehatan.</span>
                @endif
            </p>
        </div>

        {{-- Edukasi Tambahan di Laporan --}}
        <div class="mt-4 p-3 border border-blue-100 bg-blue-50 rounded-lg">
            <p class="text-[9px] text-blue-800 leading-tight">
                <strong>Catatan Penting:</strong> Hasil deteksi AI di atas merupakan alat bantu skrining awal.
                Ibu hamil disarankan untuk tetap melakukan kontrol rutin minimal 1 kali selama masa kehamilan ke dokter gigi
                untuk mencegah risiko kelahiran prematur atau BBLR (Berat Bayi Lahir Rendah) akibat infeksi gusi.
            </p>
        </div>
    </div>

    {{-- Penutup --}}
    <div class="mt-10 flex justify-end text-sm">
        <div class="text-center w-64 border-t border-black pt-2">
            <p>Tenaga Kesehatan,</p>
            <div class="h-16"></div> {{-- Space untuk TTD --}}
            <p class="font-bold uppercase underline">{{ Auth::user()->name }}</p>
            <p class="text-xs">
                NIP: {{ Auth::user()->lecturer->nip ?? '..........................' }}
            </p>
        </div>
    </div>

    <button onclick="handlePrint()" class="no-print fixed bottom-8 right-8 bg-blue-600 text-white px-5 py-3 rounded-full shadow-lg font-bold text-xs uppercase tracking-widest active:scale-95 transition-all">
        Cetak Laporan
    </button>

    <script>
        function handlePrint() {
            // Cek apakah fungsi AndroidPrint ada (berarti dibuka di WebView kita)
            if (window.AndroidPrint && window.AndroidPrint.printPage) {
                window.AndroidPrint.printPage();
            } else {
                // Jika dibuka di Chrome biasa atau Desktop
                window.print();
            }
        }
    </script>
</body>

</html>
