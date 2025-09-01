@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 text-center">Tambah Report</h1>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('dashboard.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="shift">Shift</label>
                            <select id="shift" name="shift" class="form-control" required>
                                <option value="">-- Pilih Shift --</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="mulai_kerja">Mulai Kerja</label>
                            <input id="mulai_kerja" name="mulai_kerja" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="selesai_kerja">Selesai Kerja</label>
                            <input id="selesai_kerja" name="selesai_kerja" class="form-control" required>
                        </div>


                        <div class="form-group">
                            <label for="bagian">Workstation</label>
                            <input type="text" id="bagian" name="bagian" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="sub_bagian">Mesin</label>
                            <input type="text" id="sub_bagian" name="sub_bagian" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea id="notes" name="catatan" class="form-control"></textarea>
                        </div>


                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
