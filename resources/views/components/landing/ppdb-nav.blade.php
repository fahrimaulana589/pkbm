<div class="flex flex-wrap justify-center gap-2 mb-8 p-1 bg-gray-100 rounded-lg w-fit mx-auto">
    @php
        $navs = [
            ['label' => 'Sambutan', 'route' => 'ppdb.pkbm'],
            ['label' => 'Pendaftaran', 'route' => 'ppdb.daftar'],
            ['label' => 'Info PPDB', 'route' => 'ppdb.info'],
            ['label' => 'Pengecekan', 'route' => 'ppdb.check'],
        ];
    @endphp

    @foreach($navs as $nav)
        @php
            $isActive = request()->routeIs($nav['route']);
            if ($nav['route'] === 'ppdb.pendaftar.index' && request()->routeIs('ppdb.pendaftar.*')) {
                $isActive = true;
            }
        @endphp
        <a href="{{ route($nav['route']) }}"
            class="px-6 py-2 rounded-md text-sm font-medium transition-all duration-200 {{ $isActive ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-200' }}">
            {{ $nav['label'] }}
        </a>
    @endforeach
</div>