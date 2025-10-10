@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 text-center">Import Production Report</h1>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <!-- ALERT SUCCESS & ERROR -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- FORM -->
                    <form action="{{ route('ppic.import.process') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf

                        <!-- PILIH DIVISI -->
                        <div class="form-group mb-3">
                            <label for="divisi">Divisi</label>
                            <select class="form-control @error('divisi_id') is-invalid @enderror" 
                                    name="divisi_id" id="divisi" required>
                                <option value="" selected disabled>Pilih Divisi</option>
                                @foreach ($divisis as $divisi)
                                    <option value="{{ $divisi->id }}" 
                                        {{ old('divisi_id') == $divisi->id ? 'selected' : '' }}>
                                        {{ $divisi->divisi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('divisi_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- UPLOAD FILE -->
                        <div class="form-group mb-3">
                            <label for="file">File Excel</label>
                            <input type="file" 
                                name="file" 
                                id="file" 
                                class="form-control @error('file') is-invalid @enderror" 
                                accept=".xlsx,.csv" required>
                            @error('file')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                            <small class="form-text text-muted">
                                Format yang didukung: <strong>.xlsx</strong>
                            </small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="sheet">Pilih Tanggal Sheet</label>
                            <select name="sheet" id="sheet" class="form-control" required>
                                <option value="" selected disabled>Pilih Tanggal</option>
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>





                        <!-- BUTTON -->
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Import
                            </button>
                            <a href="{{ route('ppic.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
