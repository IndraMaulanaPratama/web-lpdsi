@component('mail::message')
    {{-- Header --------------------------------------------------------------- --}}
    # 📮 Laporan Pengaduan Diterima

    Halo, **{{ $name }}** 👋
    Terima kasih telah mengirimkan {{ Str::lower($subjek ?? 'pengaduan') }} kepada kami. Berikut ringkasan laporan Anda:

    **Nama** : {{ $name }}
    **Email** : {{ $email }}
    **Kategori** : {{ $subjek ?? 'Pengaduan' }}
    **Waktu Kirim** : {{ now('Asia/Jakarta')->format('d M Y H:i') }}

    ### Isi Pesan
    {!! nl2br(e($pesan)) !!}


    Terima kasih atas partisipasi Anda membantu kami menjadi lebih baik.

    Salam hangat,
    {{ config('app.name') }}
@endcomponent
