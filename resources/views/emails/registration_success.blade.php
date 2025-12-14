<!DOCTYPE html>
<html>

<head>
    <title>Pendaftaran Berhasil</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 8px;">
        <h2 style="color: #4f46e5;">Pendaftaran Berhasil!</h2>
        <p>Halo, <strong>{{ $pendaftar->name }}</strong>.</p>
        <p>Terima kasih telah mendaftar. Data Anda telah kami terima.</p>

        <div style="background-color: #f3f4f6; padding: 15px; border-radius: 6px; margin: 20px 0; text-align: center;">
            <p style="margin: 0; font-size: 14px; color: #6b7280;">Kode Pendaftaran Anda:</p>
            <h1 style="margin: 10px 0; font-size: 32px; letter-spacing: 2px; color: #111827;">{{ $pendaftar->code }}
            </h1>
            <p style="margin: 0; font-size: 12px; color: #ef4444; font-weight: bold;">(SIMPAN KODE INI)</p>
        </div>

        <p>Silakan simpan Kode Pendaftaran di atas. Kode tersebut digunakan untuk mengecek status pendaftaran Anda di
            website kami.</p>

        <p>Terima kasih,<br>Panitia PPDB {{ config('app.name') }}</p>
    </div>
</body>

</html>