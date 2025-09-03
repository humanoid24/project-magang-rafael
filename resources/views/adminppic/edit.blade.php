@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 text-center">Edit Perintah Pekerjaan</h1>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('ppic.update', $report->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- method PUT untuk update -->

                        <div class="form-group">
                            <label for="so_no">SO NO</label>
                            <input name="so_no" type="text" class="form-control" value="{{ old('so_no', $report->so_no) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="customer">CUSTOMER</label>
                            <input name="customer" type="text" class="form-control" value="{{ old('customer', $report->customer) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="pdo_crd">PDO CRD</label>
                            <input name="pdo_crd" type="text" class="form-control" value="{{ old('pdo_crd', $report->pdo_crd) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="item_name">ITEM NAME</label>
                            <input type="text" name="item_name" class="form-control" value="{{ old('item_name', $report->item_name) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="pdoc_n">PDO CRD</label>
                            <input type="text" name="pdoc_n" class="form-control" value="{{ old('pdoc_n', $report->pdoc_n) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="item">ITEM</label>
                            <input type="text" name="item" class="form-control" value="{{ old('item', $report->item) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="pdoc_m">PDO CRD</label>
                            <input type="text" name="pdoc_m" class="form-control" value="{{ old('pdoc_m', $report->pdoc_m) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="actual">ACTUAL</label>
                            <input type="text" name="actual" class="form-control" value="{{ old('actual', $report->actual) }}" required>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('ppic.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
