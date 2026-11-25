<div class="space-y-6">
    <!-- Header -->
    <x-ui.header
        title="Monitoring Survei APMO per Wilayah"
        subtitle="Pantau kecamatan dan desa/kelurahan yang sudah atau belum mengirim isian angket survei APMO. Baris merah menandakan wilayah tanpa isian."
        icon="map-pinned"
        badge="APMO Coverage"
    >
        <x-slot:actions>
            <x-ui.button href="{{ route('admin.partisipasi.statistik') }}" variant="secondary" icon="bar-chart-3">
                Statistik APMO
            </x-ui.button>
            <x-ui.button href="{{ route('admin.partisipasi.log') }}" variant="secondary" icon="list">
                Log Partisipasi
            </x-ui.button>
        </x-slot:actions>
    </x-ui.header>

    <!-- Ringkasan -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <x-ui.stat-card
            title="Total Isian Survei"
            :value="number_format($ringkasan['totalIsian'])"
            icon="clipboard-list"
            description="Seluruh jawaban angket APMO"
        />
        <x-ui.stat-card
            title="Kecamatan Terisi"
            :value="number_format($ringkasan['kecamatanTerisi'])"
            icon="map-pin"
            :description="'dari ' . number_format($ringkasan['kecamatanTotal']) . ' kecamatan'"
        />
        <x-ui.stat-card
            title="Desa Terisi"
            :value="number_format($ringkasan['desaTerisi'])"
            icon="map"
            :description="'dari ' . number_format($ringkasan['desaTotal']) . ' desa/kelurahan'"
        />
        <x-ui.stat-card
            title="Kecamatan Belum Input"
            :value="number_format($ringkasan['kecamatanBelum'])"
            icon="alert-triangle"
            description="Ditandai merah pada tabel"
        />
    </div>

    @if($ringkasan['isianTanpaMaster'] > 0)
        <x-ui.alert type="warning" title="Sebagian isian tidak mengenali wilayah master">
            {{ number_format($ringkasan['isianTanpaMaster']) }} isian survei memakai nama kecamatan yang tidak cocok dengan data master wilayah, sehingga tidak masuk hitungan tabel di bawah.
        </x-ui.alert>
    @endif

    <!-- Filter -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex flex-col lg:flex-row lg:items-center gap-3">
            <div class="inline-flex self-start rounded-xl border border-slate-200 bg-slate-50 p-1 text-xs font-bold">
                <button type="button" wire:click="pilihTab('kecamatan')"
                    class="px-3.5 py-2 rounded-lg transition cursor-pointer {{ $tab === 'kecamatan' ? 'bg-white text-emerald-700 shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                    Kecamatan
                    <span class="ml-1 text-[10px] font-black {{ $tab === 'kecamatan' ? 'text-emerald-600' : 'text-slate-400' }}">{{ $ringkasan['kecamatanTotal'] }}</span>
                </button>
                <button type="button" wire:click="pilihTab('desa')"
                    class="px-3.5 py-2 rounded-lg transition cursor-pointer {{ $tab === 'desa' ? 'bg-white text-emerald-700 shadow-xs' : 'text-slate-500 hover:text-slate-700' }}">
                    Desa / Kelurahan
                    <span class="ml-1 text-[10px] font-black {{ $tab === 'desa' ? 'text-emerald-600' : 'text-slate-400' }}">{{ $ringkasan['desaTotal'] }}</span>
                </button>
            </div>

            <div class="flex-1">
                <x-form.input
                    wire:model.live.debounce.300ms="cari"
                    placeholder="Cari nama kecamatan atau desa/kelurahan..."
                    icon="search"
                    size="sm"
                />
            </div>

            <div class="flex items-center gap-3 text-[11px] font-bold text-slate-500">
                <span class="inline-flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Sudah input
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span> Belum input
                </span>
            </div>
        </div>
    </div>

    <!-- Tabel -->
    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 text-[11px] uppercase tracking-wider">
                    <tr>
                        <th class="p-4">
                            <button type="button" wire:click="urutkan('nama')" class="inline-flex items-center gap-1 font-bold uppercase tracking-wider hover:text-emerald-700 transition cursor-pointer">
                                {{ $tab === 'kecamatan' ? 'Kecamatan' : 'Desa / Kelurahan' }}
                                @if($urut === 'nama')
                                    <i data-lucide="{{ $arah === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="w-3.5 h-3.5"></i>
                                @else
                                    <i data-lucide="chevrons-up-down" class="w-3.5 h-3.5 opacity-40"></i>
                                @endif
                            </button>
                        </th>
                        @if($tab === 'kecamatan')
                            <th class="p-4">Desa Terisi</th>
                        @else
                            <th class="p-4">Kecamatan</th>
                        @endif
                        <th class="p-4 text-center">
                            <button type="button" wire:click="urutkan('total')" class="inline-flex items-center gap-1 font-bold uppercase tracking-wider hover:text-emerald-700 transition cursor-pointer">
                                Jumlah Isian
                                @if($urut === 'total')
                                    <i data-lucide="{{ $arah === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="w-3.5 h-3.5"></i>
                                @else
                                    <i data-lucide="chevrons-up-down" class="w-3.5 h-3.5 opacity-40"></i>
                                @endif
                            </button>
                        </th>
                        <th class="p-4 whitespace-nowrap">Terakhir Isian</th>
                        <th class="p-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($baris as $item)
                        <tr wire:key="{{ $tab }}-{{ $item['id'] }}"
                            class="transition-colors {{ $item['total'] === 0 ? 'bg-rose-50/70 hover:bg-rose-50' : 'hover:bg-slate-50/60' }}">
                            <td class="p-4">
                                <span class="font-extrabold {{ $item['total'] === 0 ? 'text-rose-700' : 'text-slate-900' }}">
                                    {{ $tab === 'kecamatan' ? 'Kec. ' : '' }}{{ $item['nama'] }}
                                </span>
                            </td>
                            <td class="p-4">
                                @if($tab === 'kecamatan')
                                    <span class="font-bold text-slate-700">{{ $item['desa_terisi'] }}/{{ $item['jumlah_desa'] }}</span>
                                    <span class="text-[11px] text-slate-400">desa</span>
                                    <span class="mt-1 block h-1 w-24 rounded-full bg-slate-100 overflow-hidden">
                                        <span class="block h-full rounded-full {{ $item['desa_terisi'] === 0 ? 'bg-rose-300' : 'bg-emerald-400' }}"
                                              style="width: {{ $item['jumlah_desa'] > 0 ? round($item['desa_terisi'] / $item['jumlah_desa'] * 100) : 0 }}%"></span>
                                    </span>
                                @else
                                    <span class="text-slate-600 font-semibold">{{ $item['wilayah'] ? 'Kec. ' . $item['wilayah'] : '-' }}</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <span class="inline-flex min-w-[2rem] justify-center px-2.5 py-1 rounded-xl font-black {{ $item['total'] === 0 ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-800' }}">
                                    {{ number_format($item['total']) }}
                                </span>
                            </td>
                            <td class="p-4 whitespace-nowrap text-slate-500 text-xs">
                                {{ $item['terakhir'] ?? '—' }}
                            </td>
                            <td class="p-4 text-center">
                                <x-ui.badge :variant="$item['total'] === 0 ? 'rose' : 'emerald'" :dot="true" size="sm">
                                    {{ $item['total'] === 0 ? 'Belum input' : 'Sudah input' }}
                                </x-ui.badge>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center">
                                <i data-lucide="inbox" class="w-8 h-8 mx-auto text-slate-300"></i>
                                <p class="mt-2 text-sm font-bold text-slate-600">Tidak ada wilayah yang cocok</p>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    @if(trim($cari) !== '')
                                        Ubah kata kunci pencarian atau kosongkan kolom cari.
                                    @else
                                        Data master {{ $tab === 'kecamatan' ? 'kecamatan' : 'desa/kelurahan' }} belum tersedia.
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-slate-100 bg-slate-50/60 text-[11px] font-semibold text-slate-500">
            {{ number_format(count($baris)) }} {{ $tab === 'kecamatan' ? 'kecamatan' : 'desa/kelurahan' }} ditampilkan ·
            Klik judul kolom "{{ $tab === 'kecamatan' ? 'Kecamatan' : 'Desa / Kelurahan' }}" atau "Jumlah Isian" untuk mengurutkan.
        </div>
    </div>
</div>
