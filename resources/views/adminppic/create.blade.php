@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 text-center">Tambah Perintah Pekerjaan</h1>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('ppic.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="so_no">SO NO</label>
                            <input name="so_no" type="text" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="customer">CUSTOMER</label>
                            <input name="customer" type="text" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="pdo_crd">PDO CRD</label>
                            <input name="pdo_crd" type="text" class="form-control" required>
                        </div>


                        <div class="form-group">
                            <label for="item_name">ITEM NAME</label>
                            <input type="text" name="item_name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="pdoc_n">PDO CRD</label>
                            <input type="text" name="pdoc_n" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="item">ITEM</label>
                            <input type="text" name="item" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="pdoc_m">PDO CRD</label>
                            <input type="text" name="pdoc_m" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="actual">ACTUAL</label>
                            <input type="text" name="actual" class="form-control" required>
                        </div>

                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('ppic.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection