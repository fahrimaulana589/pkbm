<!DOCTYPE html>
<html>

<head>
    <title>Pendaftaran Berhasil</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 8px;">
        @php
            $pkbm = \App\Models\PkbmProfile::first();
            $appName = $pkbm->nama_pkbm ?? config('app.name');
            // Logo need absolute url for email
            $logoUrl = ($pkbm && $pkbm->logo) ? \Illuminate\Support\Facades\Storage::url($pkbm->logo) : asset('images/app-logo.svg');
            // Ensure full URL if using STORAGE (S3/Local) usually returns relative path for local driver if not configured properly with full domain.
            // For simple implementation, assuming Storage::url returns valid URL or we prepend app.url
            if (!filter_var($logoUrl, FILTER_VALIDATE_URL)) {
                $logoUrl = url($logoUrl);
            }
        @endphp

        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ $logoUrl }}" alt="{{ $appName }}" style="height: 60px; width: auto;">
        </div>

        <h2 style="color: #4f46e5; text-align: center;">Pendaftaran Berhasil!</h2>
        <p>Halo, <strong>{{ $pendaftar->name }}</strong>.</p>
        <p>Terima kasih telah mendaftar di <strong>{{ $appName }}</strong>. Data Anda telah kami terima.</p>

        <div style="background-color: #f3f4f6; padding: 15px; border-radius: 6px; margin: 20px 0; text-align: center;">
            <p style="margin: 0; font-size: 14px; color: #6b7280;">Kode Pendaftaran Anda:</p>
            <h1 style="margin: 10px 0; font-size: 32px; letter-spacing: 2px; color: #111827;">{{ $pendaftar->code }}
            </h1>
            <p style="margin: 0; font-size: 12px; color: #ef4444; font-weight: bold;">(JANGAN SAMPAI HILANG!)</p>
        </div>

        <p>Silakan simpan <strong>Kode Pendaftaran</strong> di atas. Kode tersebut WAJIB digunakan untuk mengecek status
            pendaftaran Anda di
            website kami.</p>

        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('ppdb.check') }}"
                style="background-color: #4f46e5; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Cek
                Status Pendaftaran</a>
        </div>

        <p style="margin-top: 30px; font-size: 14px; color: #6b7280;">Terima kasih,<br>Panitia PPDB {{ $appName }}</p>
    </div>
</body>

</html>