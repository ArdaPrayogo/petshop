@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Daftar Hewan Peliharaan</h2>
        <a href="{{ route('pets.create') }}" class="btn btn-success mb-3"><i class="bi bi-heart-fill"></i> Tambah Hewan</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Ras</th>
                    <th>Usia</th>
                    <th>Pemilik</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pets as $pet)
                    <tr>
                        <td>{{ $pet->name }}</td>
                        <td>{{ $pet->species }}</td>
                        <td>{{ $pet->breed ?? '-' }}</td>
                        <td>{{ $pet->age ?? '-' }} tahun</td>
                        <td>{{ $pet->user->name }}</td>
                        <td>
                            <a href="{{ route('pets.show', $pet) }}" class="btn btn-info btn-sm">Lihat</a>
                            <a href="{{ route('pets.edit', $pet) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('pets.destroy', $pet) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
