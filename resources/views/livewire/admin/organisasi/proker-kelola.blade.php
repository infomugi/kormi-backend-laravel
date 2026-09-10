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
                    <span>ORGANISASI</span><span>•</span><span class="text-orange-600">PROGRAM KERJA</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Kelola Program Kerja</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Rencana dan realisasi kegiatan KORMI per bidang dan tahun anggaran.</p>
            </div>
            <button type="button" wire:click="bukaFormTambah" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-emerald-600/20 transition-all cursor-pointer self-start sm:self-auto active:scale-95">
                <i data-lucide="plus-circle" class="w-4 h-4"></i><span>Tambah Proker</span>
            </button>
        </div>

        <!-- STATS -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs text-center">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Rencana</p>
                <p class="text-xl font-black text-blue-600 mt-1">{{ $statusCounts['rencana'] ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs text-center">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Berjalan</p>
                <p class="text-xl font-black text-amber-600 mt-1">{{ $statusCounts['berjalan'] ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs text-center">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Selesai</p>
                <p class="text-xl font-black text-emerald-600 mt-1">{{ $statusCounts['selesai'] ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs text-center">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Ditunda</p>
                <p class="text-xl font-black text-red-500 mt-1">{{ $statusCounts['ditunda'] ?? 0 }}</p>
            </div>
        </div>

        <!-- FILTER & SEARCH -->
        <div class="bg-white border border-slate-200/80 p-4 rounded-3xl shadow-xs flex flex-col sm:flex-row items-center gap-4">
            <div class="relative flex-1">
                <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" wire:model.live.debounce.300ms="cari" placeholder="Cari nama kegiatan..." class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
            </div>
            <select wire:model.live="filterTahun" class="px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                <option value="">Semua Tahun</option>
                @foreach($tahunList as $t)
                    <option value="{{ $t }}">{{ $t }}</option>
                @endforeach
            </select>
            <select wire:model.live="filterBidang" class="px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                <option value="">Semua Bidang</option>
                @foreach($bidangList as $b)
                    <option value="{{ $b }}">{{ $b }}</option>
                @endforeach
            </select>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200/80">
                            <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Tahun</th>
                            <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Bidang</th>
                            <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 uppercase tracking-wider">Nama Kegiatan</th>
                            <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-[11px] font-black text-slate-500 uppercase tracking-wider">Anggaran</th>
                            <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($prokerList as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $item->tahun_anggaran }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ $item->nama_bidang }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ Str::limit($item->nama_kegiatan, 50) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold
                                        {{ $item->status_kegiatan === 'rencana' ? 'bg-blue-50 text-blue-700' : '' }}
                                        {{ $item->status_kegiatan === 'berjalan' ? 'bg-amber-50 text-amber-700' : '' }}
                                        {{ $item->status_kegiatan === 'selesai' ? 'bg-emerald-50 text-emerald-700' : '' }}
                                        {{ $item->status_kegiatan === 'ditunda' ? 'bg-red-50 text-red-700' : '' }}
                                    ">{{ ucfirst($item->status_kegiatan) }}</span>
                                </td>
                                <td class="px-6 py-4 text-right text-slate-600 text-xs font-mono">{{ $item->anggaran_rupiah }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <button wire:click="bukaFormEdit('{{ $item->id }}')" class="p-2 rounded-xl text-blue-600 hover:bg-blue-50 transition-colors cursor-pointer"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                                        <button wire:click="hapus('{{ $item->id }}')" wire:confirm="Yakin ingin menghapus program kerja ini?" class="p-2 rounded-xl text-red-500 hover:bg-red-50 transition-colors cursor-pointer"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-12 text-center text-slate-400 text-sm">Belum ada data program kerja.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-100">{{ $prokerList->links() }}</div>
        </div>

    @else

        <div class="flex items-center gap-3 mb-2">
            <button type="button" wire:click="kembaliKeTabel" class="p-2 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer"><i data-lucide="arrow-left" class="w-5 h-5 text-slate-600"></i></button>
            <h1 class="text-2xl font-black text-slate-900">{{ $editId ? 'Edit Proker' : 'Tambah Proker Baru' }}</h1>
        </div>

        <form wire:submit="simpan" class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Tahun Anggaran <span class="text-red-500">*</span></label>
                    <input type="number" wire:model="tahun_anggaran" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" min="2020" max="2035">
                    @error('tahun_anggaran') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Nama Bidang <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="nama_bidang" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" placeholder="Bidang Olahraga Tradisional" list="bidang-suggestions">
                    <datalist id="bidang-suggestions">
                        @foreach($bidangList as $b)
                            <option value="{{ $b }}">
                        @endforeach
                    </datalist>
                    @error('nama_bidang') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Status <span class="text-red-500">*</span></label>
                    <select wire:model="status_kegiatan" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        <option value="rencana">Rencana</option>
                        <option value="berjalan">Berjalan</option>
                        <option value="selesai">Selesai</option>
                        <option value="ditunda">Ditunda</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">Nama Kegiatan <span class="text-red-500">*</span></label>
                <input type="text" wire:model="nama_kegiatan" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" placeholder="Nama kegiatan/program kerja...">
                @error('nama_kegiatan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">Tujuan Kegiatan</label>
                <textarea wire:model="tujuan_kegiatan" rows="3" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 resize-none" placeholder="Tujuan dari kegiatan ini..."></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Target Sasaran</label>
                    <input type="text" wire:model="target_sasaran" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" placeholder="Masyarakat umum, Inorga, dst.">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Estimasi Anggaran (Rp)</label>
                    <input type="number" wire:model="estimasi_anggaran" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" step="1000" min="0" placeholder="50000000">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Ikon (Lucide)</label>
                    <input type="text" wire:model="ikon" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" placeholder="activity">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Bulan Mulai</label>
                    <select wire:model="bulan_mulai" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        <option value="">-- Pilih Bulan --</option>
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $b)
                            <option value="{{ $i + 1 }}">{{ $b }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Bulan Selesai</label>
                    <select wire:model="bulan_selesai" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        <option value="">-- Pilih Bulan --</option>
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $b)
                            <option value="{{ $i + 1 }}">{{ $b }}</option>
                        @endforeach
                    </select>
                </div>
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
