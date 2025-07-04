@extends('layouts.main')

@section('container')
    <div class="">
        {{-- Alert Berhasil Tambah/Edit --}}
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show col-lg-12" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Alert Berhasil Hapus --}}
        @if (session()->has('deleted'))
            <div class="alert alert-danger alert-dismissible fade show col-lg-12" role="alert">
                {{ session('deleted') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <div class="container">
        <h2>Daftar Layanan</h2>
        <a href="/service/create" class="btn btn-primary mb-2">Tambah Layanan</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Durasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr>
                        <td>{{ $service->name }}</td>
                        <td>Rp{{ number_format($service->price) }}</td>
                        <td>{{ $service->duration }} menit</td>
                        <td>
                            <a href="/service/{{ $service->id }}" class="btn btn-sm btn-primary">Detail</a>
                            <a href="/service/{{ $service->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                            <form action="/service/{{ $service->id }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Hapus layanan ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
