@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Daftar Pengingat Pembayaran</h2>

        <!-- Flash message sukses -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Kontak</th>
                    <th>Pelanggan</th>
                    <th>Kontrak</th>
                    <th>Tanggal Jatuh Tempo</th>
                    <th>Sisa Hari</th>
                    <th>Status</th>
                    <th>Aksi</th> {{-- fix --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($pengingat as $item)
                    <tr>
                        <td>
                            {{ $item->kontrak->pelanggan->nama_lengkap }} <br>
                            📞 {{ $item->kontrak->pelanggan->no_hp }} <br>
                            ✉️ {{ $item->kontrak->pelanggan->email }}
                        </td>
                        <td>{{ $item->kontrak->pelanggan->nama_lengkap }}</td>
                        <td>{{ $item->kontrak->nomor_kontrak }}</td>
                        <td>{{ $item->tanggal_jatuh_tempo }}</td>
                        <td>{{ $item->sisa_hari }} hari</td>
                        <td>{{ $item->status_angsuran }}</td>

                        <td>
                            @if ($item->sisa_hari <= 14)
                                <form action="{{ route('marketing.pengingat.kirim', $item->angsuran_id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-warning mt-2">Kirim Email</button>
                                </form>
                            @else
                                <span class="badge bg-success">Tidak Perlu</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection