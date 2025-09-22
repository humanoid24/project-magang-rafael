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
                <th>SO NO</th>
                <th>Customer</th>
                <th>PDO CRD</th>
                <th>Item Name</th>
                <th>QTY</th>
                <th>Weight/PCS</th>
                <th>Weight Total</th>
                <th>Nama Pekerja</th>
                <th>Shift</th>
                <th>Mulai Kerja</th>
                <th>Selesai Kerja</th>
                <th>Lama Kerja</th>
                <th>Workcenter</th>
                <th>Mesin</th>
                <th>Actual</th>
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
                    <td>{{ $item->so_no }}</td>
                    <td>{{ $item->customer }}</td>
                    <td>{{ $item->pdo_crd }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ rtrim(rtrim($item->weight_pcs, '0'), '.') }}</td>
                    <td>{{ $item->weight_total }}</td>
                    <td>{{ optional($item->user)->name ?? '-' }}</td>

                    <td>{{ $item->shift }}</td>
                    <td>{{ $item->mulai_kerja }}</td>
                    <td>{{ $item->selesai_kerja }}</td>
                    <td>
                        @if ($item->mulai_kerja && $item->selesai_kerja)
                            {{ \Carbon\Carbon::parse($item->mulai_kerja)->diffInMinutes(\Carbon\Carbon::parse($item->selesai_kerja)) }} menit
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ $item->bagian }}</td>
                    <td>{{ $item->sub_bagian }}</td>
                    <td>{{ $item->actual }}</td>
                    <td>{{ $item->catatan }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
</body>
</html>
