@component('mail::message')
# Pengingat Pembayaran

Halo {{ $pelanggan->nama_lengkap }},

Ini adalah pengingat bahwa pembayaran angsuran Anda dengan nomor kontrak **{{ $kontrak->nomor_kontrak }}**
akan jatuh tempo pada **{{ \Carbon\Carbon::parse($angsuran->tanggal_jatuh_tempo)->format('d-m-Y') }}**.

Sisa waktu pembayaran: **{{ $angsuran->sisa_hari }} hari**

@component('mail::button', ['url' => 'http://localhost:8000'])
Bayar Sekarang
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent