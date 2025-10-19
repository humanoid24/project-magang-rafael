@extends('layouts.app')

@section('content')
<h1 class="h3 mb-2 text-gray-800 text-center">Table Kerja Press</h1>


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
        <form method="GET" action="{{ route('ppic.press.filter') }}">
            <div class="form-group">
                <label for="tanggal_awal">Tanggal Awal</label>
                <input type="date" id="tanggal_awal" name="tanggal_report" class="form-control" value="{{ request('tanggal_report') }}">
            </div>

            <div class="form-group">
                <label for="tanggal_akhir">Tanggal Akhir</label>
                <input type="date" id="tanggal_akhir" name="tanggal_report_akhir" class="form-control" value="{{ request('tanggal_report_akhir') }}">
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
        <h5 class="modal-title" id="exportModalLabel">Export Laporan Press</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

      </div>
      <div class="modal-body">
        <form method="GET" action="{{ route('ppic.export.press') }}">
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
  @if (in_array(Auth::user()->role, [1, 3]))
    <div class="card-header py-3">
        {{-- <a href="{{ route('ppic.create') }}" class="btn btn-primary mb-3">+ Tambah Kerja</a> --}}
        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#exportModal">
            Export Excel
        </button>
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#filterModal">
            Filter Tanggal
        </button>
        <a href="{{ route('ppic.import.form') }}" class="btn btn-success mb-3">+ Import Excel</a>
        <form action="{{ route('ppic.delete.press') }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('Yakin ingin dihapus?')" class="btn btn-danger mb-3">Hapus</button>
        </form>
    </div>
  @endif

    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
          <!-- Search Form -->
          <form method="GET" action="{{ route('ppic.press') }}" class="d-flex" role="search">
              <input type="text" name="search" value="{{ request('search') }}" 
                  class="form-control form-control-sm me-2" 
                  placeholder="Cari..." 
                  style="max-width: 220px;">
              <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
          </form>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
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

                        <th>Item/Weight</th>
                        <th>Jumlah Stroke</th>
                        <th>Actual Hasil</th>
                        <th>WEIGHT TOTAL</th>

                        <th>Mulai Kerja</th>
                        <th>Selesai Kerja</th>
                        <th>Hasil Kerja</th>
                        <th>Performa</th>
                        <th>Shift</th>
                        <th>Workcenter</th>
                        <th>Mesin</th>


                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($report as $item)
                        <tr>
                            <td>{{ ($report->currentPage() - 1) * $report->perPage() + $loop->iteration }}</td>
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
                            <td>
                                {{ $item->mulai_kerja ? \Carbon\Carbon::parse($item->mulai_kerja)->format('H:i') : '' }}
                            </td>
                            <td>
                                {{ $item->selesai_kerja ? \Carbon\Carbon::parse($item->selesai_kerja)->format('H:i') : '' }}
                            </td>

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
                            <td>{{ $item->shift }}</td>
                            <td>{{ $item->bagian }}</td>
                            <td>{{ $item->sub_bagian }}</td>
                            <td>{{ $item->catatan }}</td>

                            <td>
                                @if (isAdminPPIC())
                                    <a href="{{ route('ppic.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('ppic.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin ingin dihapus?')" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                                @endif
                                @if (isPekerja())
                                <a href="{{ route('dashboard.edit', $item->id) }}" class="btn btn-sm btn-warning">Tambah Laporan / Edit Laporan</a>       
                                @endif
                                
                                @if(isAdmin())
                                    <form action="{{ route('dashboard.destroy', $item->id) }}" method="POST" style="display:inline;">
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
            <div class="d-flex justify-content-end mt-3">
                {{ $report->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
