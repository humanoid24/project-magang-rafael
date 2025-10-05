<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>
<body>
    <h3 style="text-align: center;">{{ $title }}</h3>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>PDO DUE DATE</th>
                <th>SO NO</th>
                <th>Customer</th>
                <th>PDO CRD</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>QTY</th>
                <th>Tebal</th>
                <th>Panjang</th>
                <th>Lebar</th>
                <th>Item/Weight</th>
                <th>Jumlah Stroke</th>
                <th>Actual Hasil</th>
                <th>WEIGHT TOTAL</th>
                <th>Mulai Kerja</th>
                <th>Selesai Kerja</th>
                <th>Hasil Kerja</th>
                <th>Performa</th>
                <th>Group</th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>Workcenter</th>
                <th>Mesin</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($report as $item)
                @php
                    // daftar field yang dianggap wajib
                    $wajib = [
                        'user_id'      => $item->user_id,
                        'shift'        => $item->shift,
                        'mulai_kerja'  => $item->mulai_kerja,
                        'selesai_kerja'=> $item->selesai_kerja,
                        'bagian'       => $item->bagian,
                        'sub_bagian'   => $item->sub_bagian,
                    ];

                    // cek kelengkapan semua field
                    $lengkap = collect($wajib)->every(fn($val) => !empty($val));
                @endphp

                @if(!$lengkap)
                    @continue {{-- baris ini di-skip kalau belum lengkap --}}
                @endif

                <tr>
                    <td>{{ $no++ }}</td> 
                    <td>{{ \Carbon\Carbon::parse($item->pdo_due_date)->format('Y-m-d') }}</td>
                    <td>{{ $item->so_no }}</td>
                    <td>{{ $item->customer }}</td>
                    <td>{{ $item->pdo_crd }}</td>
                    <td>{{ $item->item_code }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->tebal }}</td>
                    <td>{{ $item->panjang }}</td>
                    <td>{{ $item->lebar }}</td>
                    <td>{{ $item->item_weight }}</td>
                    <td>{{ $item->jumlah_stroke }}</td>
                    <td>{{ $item->actual_hasil }}</td>
                    <td>{{ $item->weight_total }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->mulai_kerja)->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->selesai_kerja)->format('H:i') }}</td>
                    <td>
                        @if ($item->mulai_kerja && $item->selesai_kerja)
                            @php
                                $mulai = \Carbon\Carbon::parse($item->mulai_kerja);
                                $selesai = \Carbon\Carbon::parse($item->selesai_kerja);

                                if ($selesai->lessThan($mulai)) {
                                    $selesai->addDay(); // kalau lewat tengah malam
                                }

                                $diffJam = round($mulai->diffInSeconds($selesai) / 3600, 2);
                            @endphp

                            {{ number_format($diffJam, 2) }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $item->performa }}</td>
                    <td>{{ $item->group }}</td>
                    <td>
                        @if ($item->shift == 1)
                            {{ optional($item->user)->name ?? '' }}
                        @endif
                    </td>
                    <td>
                        @if ($item->shift == 2)
                            {{ optional($item->user)->name ?? '' }}
                        @endif
                    </td>
                    <td>
                        @if ($item->shift == 3)
                            {{ optional($item->user)->name ?? '' }}
                        @endif
                    </td>
                    <td>{{ $item->bagian }}</td>
                    <td>{{ $item->sub_bagian }}</td>
                    <td>{{ $item->catatan }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
</body>
</html>
