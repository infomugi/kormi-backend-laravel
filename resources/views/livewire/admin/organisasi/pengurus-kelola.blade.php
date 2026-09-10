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
                    <span>ORGANISASI</span><span>•</span><span class="text-blue-600">STRUKTUR PENGURUS</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Kelola Pengurus KORMI</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola struktur kepengurusan KORMI Kabupaten Bandung per periode.</p>
            </div>
            <button type="button" wire:click="bukaFormTambah" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-emerald-600/20 transition-all cursor-pointer self-start sm:self-auto active:scale-95">
                <i data-lucide="plus-circle" class="w-4 h-4"></i><span>Tambah Pengurus</span>
            </button>
        </div>

        <!-- STATS & FILTER -->
        <div class="bg-white border border-slate-200/80 p-4 rounded-3xl shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0"><i data-lucide="users" class="w-5 h-5"></i></div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Pengurus</p>
                    <p class="text-lg font-black text-slate-900">{{ $totalPengurus }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <label class="text-xs font-bold text-slate-600">Periode:</label>
                <select wire:model.live="filterPeriode" class="px-4 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                    <option value="">Semua Periode</option>
                    @foreach($periodeList as $p)
                        <option value="{{ $p->id }}">{{ $p->nama_periode }} ({{ $p->tahun_mulai }}-{{ $p->tahun_selesai }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- SEARCH -->
        <div class="bg-white border border-slate-200/80 p-4 rounded-3xl shadow-xs">
            <div class="relative">
                <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" wire:model.live.debounce.300ms="cari" placeholder="Cari nama atau jabatan..." class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors">
            </div>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200/80">
                            <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Nama Lengkap</th>
                            <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Jabatan</th>
                            <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Bidang</th>
                            <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 uppercase tracking-wider">Urutan</th>
                            <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pengurusList as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $item->nama_lengkap }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ $item->jabatan }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $item->kategori_bidang ?? '-' }}</td>
                                <td class="px-6 py-4 text-center text-slate-500 text-xs">{{ $item->periode?->nama_periode ?? '-' }}</td>
                                <td class="px-6 py-4 text-center text-slate-500">{{ $item->urutan }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <button wire:click="bukaFormEdit('{{ $item->id }}')" class="p-2 rounded-xl text-blue-600 hover:bg-blue-50 transition-colors cursor-pointer"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                        <button wire:click="hapus('{{ $item->id }}')" wire:confirm="Yakin ingin menghapus pengurus ini?" class="p-2 rounded-xl text-red-500 hover:bg-red-50 transition-colors cursor-pointer"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-12 text-center text-slate-400 text-sm">Belum ada data pengurus.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-100">{{ $pengurusList->links() }}</div>
        </div>

    @else

        <div class="flex items-center gap-3 mb-2">
            <button type="button" wire:click="kembaliKeTabel" class="p-2 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer"><i data-lucide="arrow-left" class="w-5 h-5 text-slate-600"></i></button>
            <h1 class="text-2xl font-black text-slate-900">{{ $editId ? 'Edit Pengurus' : 'Tambah Pengurus Baru' }}</h1>
        </div>

        <form wire:submit="simpan" class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Periode <span class="text-red-500">*</span></label>
                    <select wire:model="periode_id" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        @foreach($periodeList as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_periode }} ({{ $p->tahun_mulai }}-{{ $p->tahun_selesai }})</option>
                        @endforeach
                    </select>
                    @error('periode_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Urutan</label>
                    <input type="number" wire:model="urutan" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" min="0">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="nama_lengkap" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" placeholder="Nama lengkap pengurus...">
                    @error('nama_lengkap') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="jabatan" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" placeholder="Ketua Umum, Sekretaris, dst.">
                    @error('jabatan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">Kategori Bidang</label>
                <input type="text" wire:model="kategori_bidang" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" placeholder="Pimpinan Harian, Bidang Olahraga, dst.">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">Foto Pengurus</label>
                <input type="file" wire:model="uploadFoto" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                @error('uploadFoto') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
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
