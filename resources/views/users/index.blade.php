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
        <h2>Data Pelanggan</h2>
        <a href="/pelanggan/create" class="btn btn-success mb-3"><i class="bi bi-person-add"></i> Tambah User</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="/pelanggan/{{ $user->id }}" class="btn btn-info btn-sm">Lihat</a>
                            <a href="/pelanggan/{{ $user->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                            <form action="/pelanggan/{{ $user->id }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Yakin hapus?')"
                                    class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
