<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .table-container {
            display: flex;
            gap: 30px; /* jarak antar tabel */
            align-items: flex-start; /* biar sejajar di atas */
            justify-content: flex-start;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #333;
            padding: 5px 8px;
            text-align: center;
        }

        th {
            background: #f3f3f3;
        }

        h3 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h3>{{ $title }}</h3>

    <div class="table-container">
        <!-- Tabel 1 -->
        <table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th colspan="26" style="background:#f3f3f3;">DETAIL PRODUKSI</th>
            <th style="background:#fff;"></th>
            <th colspan="6" style="background:#f3f3f3;">REKAP OPERATOR</th>
            <th style="background:#fff;"></th>
            <th colspan="3" style="background:#f3f3f3;">REKAP MESIN</th>
        </tr>


        <tr>
            <!-- Kolom tabel utama -->
            <th>No</th>
            <th>PDO DUE DATE</th>
            <th>SO NO</th>
            <th>Customer</th>
            <th>PDO CRD</th>
            <th>Item Code</th>
            <th>Item Name</th>
            <th>QTY</th>
            <th>Item/Weight</th>
            <th>Jumlah Stroke</th>
            <th>Actual Hasil</th>
            <th>WEIGHT TOTAL</th>
            <th>Start</th>
            <th>Finish</th>
            <th>Total Waktu</th>
            <th>Mulai Kerja</th>
            <th>Selesai Kerja</th>
            <th>Jam Kerja</th>
            <th>Performa</th>
            <th>Group</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>Workcenter</th>
            <th>Mesin</th>
            <th>Catatan</th>

            <th style="background:#eee;"></th> <!-- pemisah antar bagian -->

            <!-- Kolom tabel rekap -->
            <th>No</th>
            <th>Operator</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>Total</th>

            <th style="background:#eee;"></th> <!-- pemisah antar bagian -->
            <th>No Mesin</th>
            <th>Jam Mesin Produktif</th>
            <th>Mesin Berdasarkan Jam Kerja</th>
            <th>Mesin On</th>
            <th>Utility Mesin Produsi</th>
        </tr>
    </thead>

    <tbody>
        @php
            $no1 = 1;

            // REKAP OPERATOR (sudah ada)
            $grouped = $report->groupBy('user_id');
            $rekapRows = $grouped->map(function($items, $userId) {
                $user = $items->first()->user;
                $shift1 = $items->where('shift', 1)->sum('hasil_jam_kerja');
                $shift2 = $items->where('shift', 2)->sum('hasil_jam_kerja');
                $shift3 = $items->where('shift', 3)->sum('hasil_jam_kerja');
                $total = $shift1 + $shift2 + $shift3;
                return [
                    'name' => $user->name ?? 'Tidak diketahui',
                    'shift1' => $shift1,
                    'shift2' => $shift2,
                    'shift3' => $shift3,
                    'total'  => $total,
                ];
            })->values();

            // REKAP MESIN
            $groupedMesin = $report->groupBy('sub_bagian');
            $rekapMesin = $groupedMesin->map(function($items, $mesin) {
                $totalJam = $items->sum('hasil_jam_kerja');
                $utility = $totalJam / 14 * 100;
                $mesin_on = $items->sum('waktu_setting');
                $utility_mesin = $totalJam / $mesin_on;
                return [
                    'mesin' => $mesin,
                    'jam_operasional' => $totalJam,
                    'utility' => $utility,
                    'mesin_on' => $mesin_on,
                    'utility_mesin' => $utility_mesin,
                ];
            })->values();
        @endphp


        @foreach($report as $index => $item)
            @php
                $wajib = [
                    'user_id'      => $item->user_id,
                    'shift'        => $item->shift,
                    'mulai_kerja'  => $item->mulai_kerja,
                    'selesai_kerja'=> $item->selesai_kerja,
                    'bagian'       => $item->bagian,
                    'sub_bagian'   => $item->sub_bagian,
                ];

                $lengkap = collect($wajib)->every(fn($val) => !empty($val));
                if (!$lengkap) continue;

                $rekap = $rekapRows[$index] ?? null;
            @endphp

            <tr>
                <!-- Data utama -->
                <td>{{ $no1++ }}</td>
                <td>{{ \Carbon\Carbon::parse($item->pdo_due_date)->format('Y-m-d') }}</td>
                <td>{{ $item->so_no }}</td>
                <td>{{ $item->customer }}</td>
                <td>{{ $item->pdo_crd }}</td>
                <td>{{ $item->item_code }}</td>
                <td>{{ $item->item_name }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->item_weight }}</td>
                <td>{{ $item->jumlah_stroke }}</td>
                <td>{{ $item->actual_hasil }}</td>
                <td>{{ $item->weight_total }}</td>
                <td>{{ \Carbon\Carbon::parse($item->mesin_on)->format('H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->selesai_kerja)->format('H:i') }}</td>
                <td>{{ $item->waktu_setting }}</td>
                <td>{{ \Carbon\Carbon::parse($item->mulai_kerja)->format('H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->selesai_kerja)->format('H:i') }}</td>
                <td>
                    @if ($item->mulai_kerja && $item->selesai_kerja)
                        @php
                            $mulai = \Carbon\Carbon::parse($item->mulai_kerja);
                            $selesai = \Carbon\Carbon::parse($item->selesai_kerja);
                            if ($selesai->lessThan($mulai)) $selesai->addDay();
                            $diffJam = round($mulai->diffInSeconds($selesai) / 3600, 2);
                        @endphp
                        {{ number_format($diffJam, 2) }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $item->performa }}</td>
                <td>{{ $item->group }}</td>
                <td>@if ($item->shift == 1) {{ optional($item->user)->name ?? '' }} @endif</td>
                <td>@if ($item->shift == 2) {{ optional($item->user)->name ?? '' }} @endif</td>
                <td>@if ($item->shift == 3) {{ optional($item->user)->name ?? '' }} @endif</td>
                <td>{{ $item->bagian }}</td>
                <td>{{ $item->sub_bagian }}</td>
                <td>{{ $item->catatan }}</td>

                <td style="background:#eee;"></td> <!-- jarak antar bagian -->

                <!-- Data rekap (jika ada baris ke-nya) -->
                @if ($rekap)
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $rekap['name'] }}</td>
                    <td>{{ number_format($rekap['shift1'], 1, ',', '.') }}</td>
                    <td>{{ number_format($rekap['shift2'], 1, ',', '.') }}</td>
                    <td>{{ number_format($rekap['shift3'], 1, ',', '.') }}</td>
                    <td>{{ number_format($rekap['total'], 1, ',', '.') }}</td>
                @else
                    <td colspan="6"></td>
                @endif

                <td style="background:#eee;"></td> <!-- jarak antar bagian -->
                
                @php
                    $mesinRekap = $rekapMesin[$index] ?? null;
                @endphp
                @if ($mesinRekap)
                    <td>{{ $mesinRekap['mesin'] }}</td>
                    <td>{{ number_format($mesinRekap['jam_operasional'], 1, ',', '.') }}</td>
                    <td>{{ number_format($mesinRekap['utility'], 1, ',', '.') }}%</td>
                    <td>{{ number_format($mesinRekap['mesin_on'], 1, ',', '.') }}%</td>
                    <td>{{ number_format($mesinRekap['utility_mesin'], 1, ',', '.') }}%</td>
                @else
                    <td colspan="3"></td>
                @endif

            </tr>
        @endforeach
    </tbody>
</table>

    </div>
</body>
</html>
