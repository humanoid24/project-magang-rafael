@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 text-center">Edit Report</h1>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('dashboard.update', $report->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="shift">Shift</label>
                            <select id="shift" name="shift" class="form-control" required>
                                <option value="">-- Pilih Shift --</option>
                                <option value="1" {{ $report->shift == 1 ? 'selected' : '' }}>1</option>
                                <option value="2" {{ $report->shift == 2 ? 'selected' : '' }}>2</option>
                                <option value="3" {{ $report->shift == 3 ? 'selected' : '' }}>3</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="mesin_on">Jam Mesin On</label>
                            <input id="mesin_on" type="datetime-local" name="mesin_on"
                            value="{{ old('mesin_on', \Carbon\Carbon::parse($report->mesin_on)->setTimezone('Asia/Jakarta')->format('Y-m-d\TH:i')) }}"
                            class="form-control" required>

                        </div>

                        <div class="form-group">
                            <label for="mulai_kerja">Mulai Kerja</label>
                            <input id="mulai_kerja" type="datetime-local" name="mulai_kerja"
                                value="{{ old('mulai_kerja', \Carbon\Carbon::parse($report->mulai_kerja)->format('Y-m-d\TH:i')) }}"
                                class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="selesai_kerja">Selesai Kerja</label>
                            <input id="selesai_kerja" type="datetime-local" name="selesai_kerja"
                                value="{{ old('selesai_kerja', \Carbon\Carbon::parse($report->selesai_kerja)->format('Y-m-d\TH:i')) }}"
                                class="form-control" required>
                        </div>


                        <div class="form-group">
                            <div class="form-group">
                                <label for="divisi">Workstation</label>
                                <input type="text" class="form-control" 
                                    value="{{ $report->divisi->divisi }}" readonly>
                                <input type="hidden" name="bagian" value="{{ $report->divisi->divisi }}">
                            </div>
                                
                        </div>

                        <div class="form-group">
                            <label for="sub_bagian">Mesin</label>
                            <input type="text" id="sub_bagian" name="sub_bagian" 
                                   value="{{ old('sub_bagian', $report->sub_bagian) }}" 
                                   class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="actual">Actual Hasil</label>
                            <input type="text" id="actual" name="actual_hasil" 
                                   value="{{ old('actual', $report->actual) }}" 
                                   class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="jumlah_stroke">Jumlah Stroke</label>
                            <input type="text" id="jumlah_stroke" name="jumlah_stroke" 
                                   value="{{ old('jumlah_stroke', $report->jumlah_stroke) }}" 
                                   class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="notes">Catatan</label>
                            <textarea id="notes" name="catatan" class="form-control">{{ old('catatan', $report->catatan) }}</textarea>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
