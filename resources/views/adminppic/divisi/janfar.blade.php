@extends('layouts.app')

@section('content')
<h1 class="h3 mb-2 text-gray-800 text-center">Table Kerja janfar</h1>

<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="filterModalLabel">Filter Laporan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="GET" action="{{ route('ppic.janfar.filter') }}">
          <div class="form-group">
            <label for="tanggal_report">Tanggal Awal</label>
            <input type="date" id="tanggal_report" name="tanggal_report" class="form-control" value="{{ request('tanggal_report') }}">
          </div>

        <div class="form-group">
            <label for="tanggal_report">Tanggal Akhir</label>
            <input type="date" id="tanggal_report" name="tanggal_report_akhir" class="form-control" value="{{ request('tanggal_report_akhir') }}">
          </div>
          <button type="submit" class="btn btn-primary mt-2">Filter</button>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exportModalLabel">Export Laporan Janfar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

      </div>
      <div class="modal-body">
        <form method="GET" action="{{ route('ppic.export.janfar') }}">
            <div class="mb-3">
                <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" required>
            </div>
            <button type="submit" class="btn btn-success">Export</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('ppic.create') }}" class="btn btn-primary mb-3">+ Tambah Kerja</a>
        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#exportModal">
            Export Excel
        </button>
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#filterModal">
            Filter Tanggal
        </button>
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
                        <th>QTY</th>
                        <th>WEIGHT/PCS</th>
                        <th>WEIGHT TOTAL</th>

                        <th>Shift</th>
                        <th>Mulai Kerja</th>
                        <th>Selesai Kerja</th>
                        <th>Lama Kerja</th>
                        <th>Workstation</th>
                        <th>Mesin</th>

                        <th>Actual</th>

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
