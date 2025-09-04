@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800 text-center">Selamat Datang</h1>
<h1 class="h3 mb-2 text-gray-800 text-center">Anda Login Sebagai {{ Auth::user()->name }}</h1>
<h1 class="h4 mb-2 text-gray-800 text-center">Silahkan Pilih Divisi Untuk Menginput</h1>




@endsection
