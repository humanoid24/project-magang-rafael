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
                <th>Shift</th>
                <th>Mulai Kerja</th>
                <th>Selesai Kerja</th>
                <th>Lama Kerja</th>
                <th>Workstation</th>
                <th>Mesin</th>
                <th>Actual</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($report as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->so_no }}</td>
                    <td>{{ $item->customer }}</td>
                    <td>{{ $item->pdo_crd }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->pdoc_n }}</td>
                    <td>{{ rtrim(rtrim($item->item, '0'), '.') }}</td>
                    <td>{{ $item->pdoc_n * $item->item }}</td>

                    <td>{{ $item->shift }}</td>
                    <td>{{ $item->mulai_kerja }}</td>
                    <td>{{ $item->selesai_kerja }}</td>
                    <td>
                        @if ($item->mulai_kerja && $item->selesai_kerja)
                            {{ \Carbon\Carbon::parse($item->mulai_kerja)->diffInMinutes(\Carbon\Carbon::parse($item->selesai_kerja)) }} menit
                        @else
                            
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
