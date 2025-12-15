<?php

use function Livewire\Volt\{state, mount};
use App\Models\PkbmProfile;

state(['isFullPage' => false]);

mount(function ($isFullPage = false) {
    // Profile is shared via View::share in AppServiceProvider
    $this->isFullPage = $isFullPage;
});

?>

<div class="w-full">
    @if(!$isFullPage)
        {{-- Landing Page View (Summary) --}}
        <section id="profil" class="py-12 bg-slate-50 dark:bg-navy-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Profil</h2>
                    <p
                        class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                        Tentang {{ $profile->nama_pkbm ?? 'PKBM SekolahKita' }}
                    </p>
                    <p class="mt-4 text-xl text-slate-500 dark:text-slate-300 lg:mx-auto">
                        {{ $profile->visi ?? 'Menjadi pusat kegiatan belajar masyarakat yang unggul dan berdaya saing.' }}
                    </p>
                </div>

                <div class="mt-10">
                    <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                </div>
                                <p class="ml-16 text-lg leading-6 font-medium text-slate-900 dark:text-white">Visi</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-slate-500 dark:text-slate-300">
                                {{ $profile->visi ?? 'Belum ada data visi.' }}
                            </dd>
                        </div>

                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                    </svg>
                                </div>
                                <p class="ml-16 text-lg leading-6 font-medium text-slate-900 dark:text-white">Misi</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-slate-500 dark:text-slate-300">
                                {{ $profile->misi ?? 'Belum ada data misi.' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>
    @else
        {{-- Dedicated Full Page View (Redesigned) --}}
        <div class="bg-white dark:bg-navy-900">
            @if($profile)
                {{-- Hero Section --}}
                <div class="relative bg-slate-900 py-16 sm:py-20 overflow-hidden">
                    <div class="absolute inset-0">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80"
                            alt="Background" class="w-full h-full object-cover opacity-20">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/90 to-slate-900/50 mix-blend-multiply">
                        </div>
                    </div>
                    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
                        <div class="max-w-2xl">
                            <h1 class="text-3xl font-bold tracking-tight text-white sm:text-5xl">Profil Lembaga</h1>
                            <p class="mt-4 text-lg leading-8 text-slate-300">
                                Mengenal lebih dekat {{ $profile->nama_pkbm ?? 'PKBM SekolahKita' }}. Dedikasi kami untuk
                                pendidikan masyarakat yang berkualitas dan berdaya saing.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Sambutan Section --}}
                @if($profile->kata_sambutan)
                    <section class="py-12 bg-white dark:bg-navy-900">
                        <div class="max-w-7xl mx-auto px-6 lg:px-8">
                            <div
                                class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-10 lg:mx-0 lg:max-w-none lg:grid-cols-2 items-center">
                                <div class="lg:pr-8">
                                    <div class="lg:max-w-lg">
                                        <h2 class="text-base font-semibold leading-7 text-primary">Sambutan Kepala PKBM</h2>
                                        <p
                                            class="mt-2 text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                                            {{ $profile->kepala_pkbm }}
                                        </p>
                                        <div
                                            class="mt-6 text-lg leading-8 text-slate-600 dark:text-slate-300 prose dark:prose-invert">
                                            {!! nl2br(e($profile->kata_sambutan)) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="relative">
                                    @if($profile->foto_sambutan)
                                        <img src="{{ asset('storage/' . $profile->foto_sambutan) }}" alt="Kepala PKBM"
                                            class="w-full rounded-xl shadow-xl ring-1 ring-gray-400/10 object-cover aspect-[4/3]"
                                            width="2432" height="1442">
                                    @else
                                        <div
                                            class="w-full aspect-[4/3] bg-slate-100 dark:bg-navy-800 rounded-xl flex items-center justify-center">
                                            <span class="text-slate-400">Foto tidak tersedia</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>
                @endif

                {{-- Visi Misi Section --}}
                <section class="py-12 bg-slate-50 dark:bg-navy-800">
                    <div class="max-w-7xl mx-auto px-6 lg:px-8">
                        <div class="mx-auto max-w-2xl text-center">
                            <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">Visi & Misi
                            </h2>
                            <p class="mt-2 text-lg leading-8 text-slate-600 dark:text-slate-300">Landasan kami dalam melangkah
                                dan berkarya.</p>
                        </div>
                        <div
                            class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-6 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-2">
                            <div
                                class="flex flex-col gap-y-6 rounded-3xl bg-white dark:bg-navy-700 p-8 ring-1 ring-gray-200 dark:ring-navy-600 shadow-sm hover:shadow-md transition-shadow">
                                <dt
                                    class="flex items-center gap-x-3 text-base font-semibold leading-7 text-slate-900 dark:text-white">
                                    <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-primary">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    Visi
                                </dt>
                                <dd class="flex flex-auto flex-col text-base leading-7 text-slate-600 dark:text-slate-300">
                                    <p class="flex-auto">{{ $profile->visi ?? 'Belum ada data visi.' }}</p>
                                </dd>
                            </div>
                            <div
                                class="flex flex-col gap-y-6 rounded-3xl bg-white dark:bg-navy-700 p-8 ring-1 ring-gray-200 dark:ring-navy-600 shadow-sm hover:shadow-md transition-shadow">
                                <dt
                                    class="flex items-center gap-x-3 text-base font-semibold leading-7 text-slate-900 dark:text-white">
                                    <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-primary">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                        </svg>
                                    </div>
                                    Misi
                                </dt>
                                <dd class="flex flex-auto flex-col text-base leading-7 text-slate-600 dark:text-slate-300">
                                    <p class="flex-auto">{{ $profile->misi ?? 'Belum ada data misi.' }}</p>
                                </dd>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Latar Belakang Section --}}
                @if($profile->latar_belakang)
                    <section class="py-12 bg-white dark:bg-navy-900">
                        <div class="max-w-7xl mx-auto px-6 lg:px-8">
                            <div class="mx-auto max-w-3xl">
                                <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl text-center mb-8">
                                    Sejarah & Latar Belakang
                                </h2>
                                <div class="prose prose-lg prose-slate dark:prose-invert mx-auto">
                                    {!! nl2br(e($profile->latar_belakang)) !!}
                                </div>
                            </div>
                        </div>
                    </section>
                @endif

                {{-- Struktur Organisasi Section --}}
                @if($profile->foto_struktur_organisasi)
                    <section class="py-12 bg-slate-50 dark:bg-navy-800">
                        <div class="max-w-7xl mx-auto px-6 lg:px-8">
                            <div class="mx-auto max-w-4xl text-center">
                                <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl mb-8">
                                    Struktur Organisasi
                                </h2>
                                <img src="{{ asset('storage/' . $profile->foto_struktur_organisasi) }}" 
                                     alt="Struktur Organisasi {{ $profile->nama_pkbm }}" 
                                     class="w-full rounded-xl shadow-lg ring-1 ring-gray-400/10">
                            </div>
                        </div>
                    </section>
                @endif

                {{-- Data Tables Section --}}
                <section class="py-12 bg-white dark:bg-navy-900">
                    <div class="max-w-7xl mx-auto px-6 lg:px-8">

                        {{-- Identitas --}}
                        <div class="mb-10 overflow-hidden rounded-xl border border-slate-200 dark:border-navy-600">
                            <div class="bg-slate-50 dark:bg-navy-800 px-6 py-4 border-b border-slate-200 dark:border-navy-600">
                                <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Identitas Satuan Pendidikan</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                                    <tbody class="divide-y divide-slate-200 dark:divide-navy-600">
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium w-1/3">Nama</th>
                                            <td class="px-6 py-3">{{ $profile->nama_pkbm }}</td>
                                        </tr>
                                        <tr class="bg-slate-50 dark:bg-navy-800">
                                            <th class="px-6 py-3 font-medium">NPSN</th>
                                            <td class="px-6 py-3">{{ $profile->npsn }}</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium">Jenjang Pendidikan</th>
                                            <td class="px-6 py-3">{{ $profile->jenjang_pendidikan ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-slate-50 dark:bg-navy-800">
                                            <th class="px-6 py-3 font-medium">Status Sekolah</th>
                                            <td class="px-6 py-3">{{ $profile->status_sekolah ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium">Alamat</th>
                                            <td class="px-6 py-3">{{ $profile->alamat }}</td>
                                        </tr>
                                        <tr class="bg-slate-50 dark:bg-navy-800">
                                            <th class="px-6 py-3 font-medium">RT / RW</th>
                                            <td class="px-6 py-3">{{ $profile->rt_rw ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium">Kode Pos</th>
                                            <td class="px-6 py-3">{{ $profile->kode_pos ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-slate-50 dark:bg-navy-800">
                                            <th class="px-6 py-3 font-medium">Kelurahan</th>
                                            <td class="px-6 py-3">{{ $profile->desa ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium">Kecamatan</th>
                                            <td class="px-6 py-3">{{ $profile->kecamatan ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-slate-50 dark:bg-navy-800">
                                            <th class="px-6 py-3 font-medium">Kabupaten / Kota</th>
                                            <td class="px-6 py-3">{{ $profile->kota ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium">Provinsi</th>
                                            <td class="px-6 py-3">{{ $profile->provinsi ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-slate-50 dark:bg-navy-800">
                                            <th class="px-6 py-3 font-medium">Negara</th>
                                            <td class="px-6 py-3">{{ $profile->negara ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium">Posisi Geografis</th>
                                            <td class="px-6 py-3">
                                                @if($profile->lintang && $profile->bujur)
                                                    Lintang: {{ $profile->lintang }}, Bujur: {{ $profile->bujur }}
                                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $profile->lintang }},{{ $profile->bujur }}" target="_blank" class="ml-2 text-primary hover:underline">(Lihat Peta)</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Data Pelengkap --}}
                        <div class="mb-10 overflow-hidden rounded-xl border border-slate-200 dark:border-navy-600">
                            <div class="bg-slate-50 dark:bg-navy-800 px-6 py-4 border-b border-slate-200 dark:border-navy-600">
                                <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Data Pelengkap</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                                    <tbody class="divide-y divide-slate-200 dark:divide-navy-600">
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium w-1/3">SK Pendirian</th>
                                            <td class="px-6 py-3">{{ $profile->sk_pendirian ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-slate-50 dark:bg-navy-800">
                                            <th class="px-6 py-3 font-medium">Tanggal SK Pendirian</th>
                                            <td class="px-6 py-3">{{ $profile->tanggal_sk_pendirian ? $profile->tanggal_sk_pendirian->format('d M Y') : '-' }}</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium">Status Kepemilikan</th>
                                            <td class="px-6 py-3">{{ $profile->status_kepemilikan ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-slate-50 dark:bg-navy-800">
                                            <th class="px-6 py-3 font-medium">SK Izin Operasional</th>
                                            <td class="px-6 py-3">{{ $profile->sk_izin_operasional ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium">Tgl SK Izin Operasional</th>
                                            <td class="px-6 py-3">{{ $profile->tanggal_sk_izin_operasional ? $profile->tanggal_sk_izin_operasional->format('d M Y') : '-' }}</td>
                                        </tr>
                                        <tr class="bg-slate-50 dark:bg-navy-800">
                                            <th class="px-6 py-3 font-medium">Kebutuhan Khusus Dilayani</th>
                                            <td class="px-6 py-3">{{ $profile->kebutuhan_khusus_dilayani ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium">Nomor Rekening</th>
                                            <td class="px-6 py-3">{{ $profile->nomor_rekening ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-slate-50 dark:bg-navy-800">
                                            <th class="px-6 py-3 font-medium">Nama Bank</th>
                                            <td class="px-6 py-3">{{ $profile->nama_bank ?? '-' }} ({{ $profile->cabang_kcp_unit ?? '-' }})</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium">Rekening Atas Nama</th>
                                            <td class="px-6 py-3">{{ $profile->rekening_atas_nama ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-slate-50 dark:bg-navy-800">
                                            <th class="px-6 py-3 font-medium">MBS</th>
                                            <td class="px-6 py-3">{{ $profile->mbs ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium">Memungut Iuran</th>
                                            <td class="px-6 py-3">{{ $profile->memungut_iuran ? 'Ya' : 'Tidak' }} @if($profile->memungut_iuran && $profile->nominal_iuran) (Rp {{ number_format($profile->nominal_iuran, 0, ',', '.') }}) @endif</td>
                                        </tr>
                                        <tr class="bg-slate-50 dark:bg-navy-800">
                                            <th class="px-6 py-3 font-medium">Nama Wajib Pajak</th>
                                            <td class="px-6 py-3">{{ $profile->nama_wajib_pajak ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium">NPWP</th>
                                            <td class="px-6 py-3">{{ $profile->npwp ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Kontak --}}
                        <div class="mb-10 overflow-hidden rounded-xl border border-slate-200 dark:border-navy-600">
                            <div class="bg-slate-50 dark:bg-navy-800 px-6 py-4 border-b border-slate-200 dark:border-navy-600">
                                <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Kontak Utama</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                                    <tbody class="divide-y divide-slate-200 dark:divide-navy-600">
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium w-1/3">Nomor Telepon</th>
                                            <td class="px-6 py-3">{{ $profile->telepon ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-slate-50 dark:bg-navy-800">
                                            <th class="px-6 py-3 font-medium">Nomor Fax</th>
                                            <td class="px-6 py-3">{{ $profile->fax ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium">Email</th>
                                            <td class="px-6 py-3">{{ $profile->email ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-slate-50 dark:bg-navy-800">
                                            <th class="px-6 py-3 font-medium">Website</th>
                                            <td class="px-6 py-3">
                                                @if($profile->website)
                                                    <a href="{{ $profile->website }}" target="_blank" class="text-primary hover:underline">{{ $profile->website }}</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Data Periodik --}}
                        <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-navy-600">
                            <div class="bg-slate-50 dark:bg-navy-800 px-6 py-4 border-b border-slate-200 dark:border-navy-600">
                                <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Data Periodik</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                                    <tbody class="divide-y divide-slate-200 dark:divide-navy-600">
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium w-1/3">Waktu Penyelenggaraan</th>
                                            <td class="px-6 py-3">{{ $profile->waktu_penyelenggaraan ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-slate-50 dark:bg-navy-800">
                                            <th class="px-6 py-3 font-medium">Bersedia Menerima BOS?</th>
                                            <td class="px-6 py-3">{{ $profile->bersedia_menerima_bos ? 'Ya' : 'Tidak' }}</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium">Sertifikasi ISO</th>
                                            <td class="px-6 py-3">Belum Bersertifikat</td> {{-- Placeholder as no field --}}
                                        </tr>
                                        <tr class="bg-slate-50 dark:bg-navy-800">
                                            <th class="px-6 py-3 font-medium">Sumber Listrik</th>
                                            <td class="px-6 py-3">{{ $profile->sumber_listrik ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium">Daya Listrik</th>
                                            <td class="px-6 py-3">{{ $profile->daya_listrik ? $profile->daya_listrik . ' Watt' : '-' }}</td>
                                        </tr>
                                        <tr class="bg-slate-50 dark:bg-navy-800">
                                            <th class="px-6 py-3 font-medium">Akses Internet</th>
                                            <td class="px-6 py-3">{{ $profile->akses_internet ?? '-' }}</td>
                                        </tr>
                                        <tr class="bg-white dark:bg-navy-700">
                                            <th class="px-6 py-3 font-medium">Akreditasi</th>
                                            <td class="px-6 py-3">{{ $profile->akreditasi ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </section>
            @else
                <div class="py-24 text-center">
                    <p class="text-slate-500">Data profil belum tersedia.</p>
                </div>
            @endif
        </div>
    @endif
</div>