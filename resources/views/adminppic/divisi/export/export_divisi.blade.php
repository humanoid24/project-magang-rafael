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
            @foreach($report as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->so_no }}</td>
                    <td>{{ $row->customer }}</td>
                    <td>{{ $row->pdo_crd }}</td>
                    <td>{{ $row->item_name }}</td>
                    <td>{{ $row->pdoc_n }}</td>
                    <td>{{ $row->item }}</td>
                    <td>{{ $row->pdoc_n * $row->item }}</td>
                    <td>{{ $row->shift }}</td>
                    <td>{{ $row->mulai_kerja }}</td>
                    <td>{{ $row->selesai_kerja }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($row->mulai_kerja)->diffInMinutes(\Carbon\Carbon::parse($row->selesai_kerja)) }} menit
                    </td>
                    <td>{{ $row->bagian }}</td>
                    <td>{{ $row->sub_bagian }}</td>
                    <td>{{ $row->actual }}</td>
                    <td>{{ $row->catatan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
