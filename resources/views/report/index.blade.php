@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Table Report</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    {{-- <div class="card-header py-3">
        @if(isPekerja())
            <a href="{{ route('dashboard.create') }}" class="btn btn-primary mb-3">+ Tambah Report</a>
        @endif
    </div> --}}

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        @if(isAdmin())
                            <th>Nama Pekerja</th>
                        @endif
                        
                        <th>SO NO</th>
                        <th>Customer</th>
                        <th>PDO CRD</th>
                        <th>Item Name</th>
                        <th>PDO N</th>
                        <th>Item</th>
                        <th>PDO M</th>
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
                    @foreach($report as $pekerja)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pekerja->so_no }}</td>
                            <td>{{ $pekerja->customer }}</td>
                            <td>{{ $pekerja->pdo_crd }}</td>
                            <td>{{ $pekerja->item_name }}</td>
                            <td>{{ $pekerja->pdoc_n }}</td>
                            <td>{{ $pekerja->item }}</td>
                            <td>{{ $pekerja->pdoc_m }}</td>
                            <td>{{ $pekerja->actual }}</td>
                            @if(isAdmin())
                                <td>{{ $pekerja->user->name ?? '-' }}</td>
                            @endif
                            <td>{{ $pekerja->shift }}</td>
                            <td>{{ $pekerja->mulai_kerja }}</td>
                            <td>{{ $pekerja->selesai_kerja }}</td>
                            <td>{{ $pekerja->bagian }}</td>
                            <td>{{ $pekerja->sub_bagian }}</td>
                            <td>{{ $pekerja->catatan }}</td>
                            <td>
                                @if (isPekerja())
                                <a href="{{ route('dashboard.edit', $pekerja->id) }}" class="btn btn-sm btn-warning">Tambah Laporan / Edit Laporan</a>       
                                @endif
                                
                                @if(isAdmin())
                                    <form action="{{ route('dashboard.destroy', $pekerja->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Yakin?')" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
