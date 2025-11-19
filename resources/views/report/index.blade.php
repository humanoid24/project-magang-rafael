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
        <div class="d-flex justify-content-end mb-3">
                <!-- Search Form -->
                <form method="GET" action="{{ route('dashboard.index') }}" class="d-flex" role="search">
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
                        @if(isAdmin())
                            <th>Nama Pekerja</th>
                        @endif
                        
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

                        <th>Jam mesin on</th>
                        <th>Jam mesin off</th>
                        <th>Waktu setting</th>


                        <th>Mulai Kerja</th>
                        <th>Selesai Kerja</th>
                        <th>Hasil Kerja</th>
                        <th>Performa</th>
                        <th>Group</th>
                        <th>Shift</th>
                        <th>Workcenter</th>
                        <th>Mesin</th>


                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($report as $pekerja)
                        @php
                            $wajib = [
                                'user_id' => $pekerja->user_id,
                                'shift' => $pekerja->shift,
                                'mulai_kerja' => $pekerja->mulai_kerja,
                                'selesai_kerja' => $pekerja->selesai_kerja,
                                'bagian' => $pekerja->bagian,
                                'sub_bagian' => $pekerja->sub_bagian,
                            ];
                            $lengkap = collect($wajib)->every(fn($val) => !empty($val));
                        @endphp

                        {{-- Kalau admin, skip data yang belum lengkap --}}
                        @if(isAdmin() && !$lengkap)
                            @continue
                        @endif

                        <tr>
                            <td>{{ ($report->currentPage() - 1) * $report->perPage() + $loop->iteration }}</td>

                            @if(isAdmin())
                                <td>{{ optional($pekerja->user)->name }}</td>
                            @endif

                            <td>{{ \Carbon\Carbon::parse($pekerja->pdo_due_date)->format('Y-m-d') }}</td>
                            <td>{{ $pekerja->so_no }}</td>
                            <td>{{ $pekerja->customer }}</td>
                            <td>{{ $pekerja->pdo_crd }}</td>
                            <td>{{ $pekerja->item_code }}</td>
                            <td>{{ $pekerja->item_name }}</td>
                            <td>{{ $pekerja->qty }}</td>
                            <td>{{ $pekerja->tebal }}</td>
                            <td>{{ $pekerja->panjang }}</td>
                            <td>{{ $pekerja->lebar }}</td>
                            <td>{{ $pekerja->item_weight }}</td>
                            <td>{{ $pekerja->jumlah_stroke }}</td>
                            <td>{{ $pekerja->actual_hasil }}</td>
                            <td>{{ $pekerja->weight_total }}</td>
                            <td>
                                {{ $pekerja->mesin_on ? \Carbon\Carbon::parse($pekerja->mesin_on) : '' }}
                            </td>
                            <td>
                                {{ $pekerja->selesai_kerja ? \Carbon\Carbon::parse($pekerja->selesai_kerja) : '' }}
                            </td>
                                @if ($pekerja->mesin_on && $pekerja->selesai_kerja)
                                    @php
                                        $mulai = \Carbon\Carbon::parse($pekerja->mesin_on);
                                        $selesai = \Carbon\Carbon::parse($pekerja->selesai_kerja);

                                        if ($selesai->lessThan($mulai)) {
                                            $selesai->addDay(); // kalau lewat tengah malam
                                        }

                                        // --- GUNAKAN METODE INI ---
                                        // diffInMinutes() langsung menghasilkan total menit sebagai angka bulat
                                        $totalMenit = $mulai->diffInMinutes($selesai);
                                    @endphp

                                    {{ $totalMenit }} Menit
                                @else
                                    -
                                @endif
                            <td>
                                {{ $pekerja->mulai_kerja ? \Carbon\Carbon::parse($pekerja->mulai_kerja) : '' }}
                            </td>
                            <td>
                                {{ $pekerja->selesai_kerja ? \Carbon\Carbon::parse($pekerja->selesai_kerja) : '' }}
                            </td>

                            <td>
                                @if ($pekerja->mulai_kerja && $pekerja->selesai_kerja)
                                    @php
                                        $mulai = \Carbon\Carbon::parse($pekerja->mulai_kerja);
                                        $selesai = \Carbon\Carbon::parse($pekerja->selesai_kerja);

                                        if ($selesai->lessThan($mulai)) {
                                            $selesai->addDay(); // kalau lewat tengah malam
                                        }

                                        // --- GUNAKAN METODE INI ---
                                        // diffInMinutes() langsung menghasilkan total menit sebagai angka bulat
                                        $totalMenit = $mulai->diffInMinutes($selesai);
                                    @endphp

                                    {{ $totalMenit }} Menit
                                @else
                                    -
                                @endif
                            </td>

                            <td>{{ $pekerja->performa }}</td>
                            <td>{{ $pekerja->group }}</td>
                            <td>{{ $pekerja->shift }}</td>
                            <td>{{ $pekerja->bagian }}</td>
                            <td>{{ $pekerja->sub_bagian }}</td>
                            <td>{{ $pekerja->catatan }}</td>

                            <td>
                                <form action="{{ route('dashboard.destroy', $pekerja->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin?')" class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
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
