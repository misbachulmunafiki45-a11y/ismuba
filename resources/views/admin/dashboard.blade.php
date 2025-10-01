@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Selamat datang</h5>
                <p class="card-text">Ini adalah halaman dashboard admin ISMUBA.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <h5 class="card-title">Info Singkat</h5>
                <p class="card-text">Tambahkan widget atau statistik di sini.</p>
            </div>
        </div>
    </div>
</div>
@endsection