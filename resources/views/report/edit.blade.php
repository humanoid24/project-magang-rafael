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
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="mulai_kerja">Mulai Kerja</label>
                            <input id="mulai_kerja" type="date" name="mulai_kerja" 
                                   value="{{ old('mulai_kerja', $report->mulai_kerja) }}" 
                                   class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="selesai_kerja">Selesai Kerja</label>
                            <input id="selesai_kerja" type="date" name="selesai_kerja" 
                                   value="{{ old('selesai_kerja', $report->selesai_kerja) }}" 
                                   class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="bagian">Workstation</label>
                            <input type="text" id="bagian" name="bagian" 
                                   value="{{ old('bagian', $report->bagian) }}" 
                                   class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="sub_bagian">Mesin</label>
                            <input type="text" id="sub_bagian" name="sub_bagian" 
                                   value="{{ old('sub_bagian', $report->sub_bagian) }}" 
                                   class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="notes">Notes</label>
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
