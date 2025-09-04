@extends('layouts.app')

@section('content')
<h1 class="h3 mb-2 text-gray-800 text-center">Table Kerja roll farming</h1>
<form method="GET" action="{{ route('ppic.rollforming') }}">
    <div class="form-group">
        <label for="tanggal_report">Tanggal</label>
        <input type="date" id="tanggal_report" name="tanggal_report" 
            class="form-control" value="{{ request('tanggal_report') }}">
    </div>
    <button type="submit" class="btn btn-primary mt-2">Filter</button>
</form>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('ppic.create') }}" class="btn btn-primary mb-3">+ Tambah Kerja</a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>SO NO</th>
                        <th>Customer</th>
                        <th>PDO CRD</th>
                        <th>Item Name</th>
                        <th>PDO CRD</th>
                        <th>Item</th>
                        <th>PDO CRD</th>
                        <th>Actual</th>

                        <th>Shift</th>
                        <th>Mulai Kerja</th>
                        <th>Selesai Kerja</th>
                        <th>Workstation</th>
                        <th>Mesin</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
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
                            <td>{{ $item->item }}</td>
                            <td>{{ $item->pdoc_m }}</td>
                            <td>{{ $item->actual }}</td>

                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>

                            <td>
                                <a href="{{ route('ppic.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('ppic.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin ingin dihapus?')" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
