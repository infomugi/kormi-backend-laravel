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
                    <span>ORGANISASI</span><span>•</span><span class="text-amber-600">SEJARAH</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Kelola Linimasa Sejarah</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Timeline perjalanan KORMI Kabupaten Bandung dari masa ke masa.</p>
            </div>
            <button type="button" wire:click="bukaFormTambah" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-emerald-600/20 transition-all cursor-pointer self-start sm:self-auto active:scale-95">
                <i data-lucide="plus-circle" class="w-4 h-4"></i><span>Tambah Sejarah</span>
            </button>
        </div>

        <!-- STATS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0"><i data-lucide="clock" class="w-6 h-6"></i></div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Timeline</p>
                    <p class="text-2xl font-black text-slate-900 mt-0.5">{{ $totalSejarah }} <span class="text-xs font-bold text-slate-400">Peristiwa</span></p>
                </div>
            </div>
        </div>

        <!-- SEARCH -->
        <div class="bg-white border border-slate-200/80 p-4 rounded-3xl shadow-xs">
            <div class="relative">
                <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" wire:model.live.debounce.300ms="cari" placeholder="Cari berdasarkan judul atau tahun..." class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors">
            </div>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200/80">
                            <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Tahun</th>
                            <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 uppercase tracking-wider">Urutan</th>
                            <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 uppercase tracking-wider">Tampil</th>
                            <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($sejarahList as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-black text-slate-900">{{ $item->tahun }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ Str::limit($item->judul, 60) }}</td>
                                <td class="px-6 py-4 text-center text-slate-500">{{ $item->urutan }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($item->status_tampil)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700">Tampil</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500">Disembunyikan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <button wire:click="bukaFormEdit('{{ $item->id }}')" class="p-2 rounded-xl text-blue-600 hover:bg-blue-50 transition-colors cursor-pointer"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                        <button wire:click="hapus('{{ $item->id }}')" wire:confirm="Yakin ingin menghapus timeline ini?" class="p-2 rounded-xl text-red-500 hover:bg-red-50 transition-colors cursor-pointer"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-12 text-center text-slate-400 text-sm">Belum ada data timeline sejarah.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-100">{{ $sejarahList->links() }}</div>
        </div>

    @else

        <!-- FORM MODE -->
        <div class="flex items-center gap-3 mb-2">
            <button type="button" wire:click="kembaliKeTabel" class="p-2 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer"><i data-lucide="arrow-left" class="w-5 h-5 text-slate-600"></i></button>
            <h1 class="text-2xl font-black text-slate-900">{{ $editId ? 'Edit Sejarah' : 'Tambah Sejarah Baru' }}</h1>
        </div>

        <form wire:submit="simpan" class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Tahun <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="tahun" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" placeholder="2015">
                    @error('tahun') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Urutan</label>
                    <input type="number" wire:model="urutan" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" min="0">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">Judul <span class="text-red-500">*</span></label>
                <input type="text" wire:model="judul" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" placeholder="Judul peristiwa penting...">
                @error('judul') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
                <textarea wire:model="deskripsi" rows="4" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 resize-none" placeholder="Deskripsi detail peristiwa..."></textarea>
                @error('deskripsi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">Gambar (opsional)</label>
                <input type="file" wire:model="uploadGambar" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                @error('uploadGambar') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" wire:model="status_tampil" id="status_tampil" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <label for="status_tampil" class="text-sm text-slate-700">Tampilkan di halaman publik</label>
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
