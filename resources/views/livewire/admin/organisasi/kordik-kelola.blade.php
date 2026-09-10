<div class="space-y-6">

    @if(session()->has('pesan'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs sm:text-sm font-bold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0"><i data-lucide="check" class="w-4 h-4"></i></div>
                <span>{{ session('pesan') }}</span>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 p-1.5 rounded-lg transition-colors cursor-pointer"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
    @endif

    @if($mode === 'tabel')

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                    <span>ORGANISASI</span><span>•</span><span class="text-teal-600">KOORDINATOR KECAMATAN</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Kelola Kordik Kecamatan</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola koordinator KORMI per kecamatan di Kabupaten Bandung.</p>
            </div>
            <button type="button" wire:click="bukaFormTambah" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-emerald-600/20 transition-all cursor-pointer self-start sm:self-auto active:scale-95">
                <i data-lucide="plus-circle" class="w-4 h-4"></i><span>Tambah Kordik</span>
            </button>
        </div>

        <!-- STATS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0"><i data-lucide="users" class="w-6 h-6"></i></div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Kordik</p>
                    <p class="text-2xl font-black text-slate-900 mt-0.5">{{ $totalKordik }}</p>
                </div>
            </div>
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0"><i data-lucide="map-pin" class="w-6 h-6"></i></div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kecamatan Terisi</p>
                    <p class="text-2xl font-black text-blue-600 mt-0.5">{{ $totalKecamatanTerisi }} <span class="text-xs font-bold text-slate-400">/ 31 Kecamatan</span></p>
                </div>
            </div>
        </div>

        <!-- FILTER -->
        <div class="bg-white border border-slate-200/80 p-4 rounded-3xl shadow-xs flex flex-col sm:flex-row items-center gap-4">
            <div class="relative flex-1">
                <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" wire:model.live.debounce.300ms="cari" placeholder="Cari nama ketua..." class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors">
            </div>
            <select wire:model.live="filterPeriode" class="px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                <option value="">Semua Periode</option>
                @foreach($periodeList as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_periode }}</option>
                @endforeach
            </select>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200/80">
                            <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Kecamatan</th>
                            <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Ketua</th>
                            <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Sekretaris</th>
                            <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 uppercase tracking-wider">No. SK</th>
                            <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($kordikList as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $item->kecamatan?->nama_kecamatan ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ $item->nama_ketua }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $item->nama_sekretaris ?? '-' }}</td>
                                <td class="px-6 py-4 text-center text-slate-500 text-xs">{{ $item->nomor_sk ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($item->status_aktif)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700">Aktif</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <button wire:click="bukaFormEdit('{{ $item->id }}')" class="p-2 rounded-xl text-blue-600 hover:bg-blue-50 transition-colors cursor-pointer"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                        <button wire:click="hapus('{{ $item->id }}')" wire:confirm="Yakin ingin menghapus kordik ini?" class="p-2 rounded-xl text-red-500 hover:bg-red-50 transition-colors cursor-pointer"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-12 text-center text-slate-400 text-sm">Belum ada data koordinator kecamatan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-100">{{ $kordikList->links() }}</div>
        </div>

    @else

        <div class="flex items-center gap-3 mb-2">
            <button type="button" wire:click="kembaliKeTabel" class="p-2 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer"><i data-lucide="arrow-left" class="w-5 h-5 text-slate-600"></i></button>
            <h1 class="text-2xl font-black text-slate-900">{{ $editId ? 'Edit Kordik' : 'Tambah Kordik Baru' }}</h1>
        </div>

        <form wire:submit="simpan" class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Kecamatan <span class="text-red-500">*</span></label>
                    <select wire:model="kecamatan_id" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        @foreach($kecamatanList as $kec)
                            <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                    @error('kecamatan_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Periode <span class="text-red-500">*</span></label>
                    <select wire:model="periode_id" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        @foreach($periodeList as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_periode }}</option>
                        @endforeach
                    </select>
                    @error('periode_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Nama Ketua <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="nama_ketua" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" placeholder="Nama ketua kordik">
                    @error('nama_ketua') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Nama Sekretaris</label>
                    <input type="text" wire:model="nama_sekretaris" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" placeholder="Nama sekretaris">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Nama Bendahara</label>
                    <input type="text" wire:model="nama_bendahara" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" placeholder="Nama bendahara">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Nomor Telepon</label>
                    <input type="text" wire:model="nomor_telepon" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" placeholder="08xxxx">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Nomor SK</label>
                    <input type="text" wire:model="nomor_sk" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" placeholder="Nomor SK pengukuhan">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">Foto Ketua</label>
                <input type="file" wire:model="uploadFoto" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                @error('uploadFoto') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" wire:model="status_aktif" id="status_aktif" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <label for="status_aktif" class="text-sm text-slate-700">Status Aktif</label>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" wire:click="kembaliKeTabel" class="px-6 py-3 rounded-2xl border border-slate-300 text-slate-700 font-bold text-xs uppercase tracking-wider hover:bg-slate-50 transition-colors cursor-pointer">Batal</button>
                <button type="submit" class="px-8 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-emerald-600/20 transition-all cursor-pointer active:scale-95">
                    <i data-lucide="save" class="w-4 h-4 inline mr-1"></i>{{ $editId ? 'Perbarui' : 'Simpan' }}
                </button>
            </div>
        </form>

    @endif

</div>
