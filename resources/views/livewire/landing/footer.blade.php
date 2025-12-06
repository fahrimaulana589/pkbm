<?php

use function Livewire\Volt\{state, mount};
use App\Models\PkbmProfile;

state(['profile' => null]);

mount(function () {
    $this->profile = PkbmProfile::first();
});

?>

<footer class="bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Brand & Contact -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-primary/20 rounded-xl flex items-center justify-center text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.499 5.516 50.552 50.552 0 00-2.658.813m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight">{{ $profile->nama_pkbm ?? 'SekolahKita' }}</span>
                </div>
                <p class="text-slate-400 text-sm mb-4">
                    {{ $profile->alamat ?? 'Alamat PKBM belum diatur.' }}
                </p>
                <div class="space-y-2 text-slate-400 text-sm">
                    <p class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        {{ $profile->telepon ?? '-' }}
                    </p>
                    <p class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ $profile->email ?? '-' }}
                    </p>
                </div>
            </div>

            <!-- Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Tautan Cepat</h3>
                <ul class="space-y-2 text-slate-400">
                    <li><a href="/" wire:navigate class="hover:text-primary transition-colors">Beranda</a></li>
                    <li><a href="/profil" wire:navigate class="hover:text-primary transition-colors">Profil</a></li>
                    <li><a href="/program" wire:navigate class="hover:text-primary transition-colors">Program</a></li>
                    <li><a href="/tutor" wire:navigate class="hover:text-primary transition-colors">Tutor</a></li>
                    <li><a href="/jadwal" wire:navigate class="hover:text-primary transition-colors">Jadwal</a></li>
                    <li><a href="/pengumuman" wire:navigate class="hover:text-primary transition-colors">Pengumuman</a>
                    </li>
                    <li><a href="/berita" wire:navigate class="hover:text-primary transition-colors">Berita</a></li>
                    <li><a href="/galeri" wire:navigate class="hover:text-primary transition-colors">Galeri</a></li>
                </ul>
            </div>

            <!-- Social & Map (Optional) -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Ikuti Kami</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-slate-400 hover:text-primary transition-colors">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-primary transition-colors">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772 4.902 4.902 0 011.772-1.153c.636-.247 1.363-.416 2.427-.465C9.673 2.013 10.03 2 12.48 2h.165zm-2.315 4.875c-2.704 0-4.875 2.171-4.875 4.875s2.171 4.875 4.875 4.875 4.875-2.171 4.875-4.875-2.171-4.875-4.875-4.875zm0 8.25c-1.864 0-3.375-1.511-3.375-3.375s1.511-3.375 3.375-3.375 3.375 1.511 3.375 3.375-1.511 3.375-3.375 3.375zm5.85-8.25c.483 0 .875.392.875.875s-.392.875-.875.875-.875-.392-.875-.875.392-.875.875-.875z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-8 pt-8 border-t border-slate-800 text-center text-slate-400 text-sm">
            &copy; {{ date('Y') }} {{ $profile->nama_pkbm ?? 'PKBM SekolahKita' }}. All rights reserved.
        </div>
    </div>
</footer>