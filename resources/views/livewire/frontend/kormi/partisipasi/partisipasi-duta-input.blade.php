<div class="py-10 max-w-4xl mx-auto px-4 sm:px-6">
    <!-- Header Duta -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-50 border border-amber-200 text-amber-800 text-xs font-black uppercase tracking-wider mb-3">
            <i data-lucide="award" class="w-3.5 h-3.5"></i>
            Portal Khusus Duta Olahraga Desa
        </div>
        <h1 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">Lapor Kegiatan Olahraga Massal Warga</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-2 max-w-xl mx-auto">
            Sebagai Duta Olahraga, laporkan kegiatan senam, jalan sehat, atau olahraga tradisional yang melibatkan warga di desa binaan Anda.
        </p>
    </div>

    @if($berhasilSimpan)
        <div class="bg-white p-8 sm:p-10 rounded-3xl border border-amber-200 shadow-xl text-center space-y-6 animate-fade-in">
            <div class="w-16 h-16 rounded-3xl bg-amber-100 text-amber-600 flex items-center justify-center mx-auto shadow-inner">
                <i data-lucide="check-circle" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900">Laporan Lapangan Berhasil Dikirim!</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Data partisipasi warga di desa Anda telah terdata dan masuk dalam kalkulasi capaian APMO Kabupaten Bandung.</p>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                <button 
                    type="button" 
                    wire:click="resetForm" 
                    class="px-6 py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs uppercase tracking-wider transition shadow-md shadow-amber-600/25 cursor-pointer"
                >
                    Lapor Kegiatan Lainnya
                </button>
                <a 
                    href="{{ route('partisipasi.riwayat') }}" 
                    class="px-6 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition cursor-pointer"
                >
                    Lihat Portofolio Duta
                </a>
            </div>
        </div>
    @else
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-lg">
            <!-- Preset Cepat Kegiatan -->
            <div class="mb-6 p-4 rounded-2xl bg-amber-50/60 border border-amber-200/60">
                <span class="text-xs font-bold text-amber-900 block mb-2">⚡ Pilihan Cepat Jenis Kegiatan:</span>
                <div class="flex flex-wrap gap-2">
                    <button type="button" wire:click="setPresetKegiatan('Senam Sehat Massal Desa', 'senam')" class="px-3 py-1 rounded-xl bg-white border border-amber-200 text-amber-800 text-xs font-bold hover:bg-amber-100 transition cursor-pointer">
                        + Senam Massal
                    </button>
                    <button type="button" wire:click="setPresetKegiatan('Jalan Santai Warga', 'jalan')" class="px-3 py-1 rounded-xl bg-white border border-amber-200 text-amber-800 text-xs font-bold hover:bg-amber-100 transition cursor-pointer">
                        + Jalan Santai
                    </button>
                    <button type="button" wire:click="setPresetKegiatan('Latihan Olahraga Tradisional', 'tradisional')" class="px-3 py-1 rounded-xl bg-white border border-amber-200 text-amber-800 text-xs font-bold hover:bg-amber-100 transition cursor-pointer">
                        + Olahraga Tradisional
                    </button>
                    <button type="button" wire:click="setPresetKegiatan('Gowes / Sepeda Santai Bersama', 'sepeda')" class="px-3 py-1 rounded-xl bg-white border border-amber-200 text-amber-800 text-xs font-bold hover:bg-amber-100 transition cursor-pointer">
                        + Sepeda Santai
                    </button>
                </div>
            </div>

            <form wire:submit.prevent="simpan" class="space-y-6">
                <!-- 1. Detail Kegiatan -->
                <div class="space-y-4">
                    <h3 class="text-xs font-black uppercase tracking-wider text-amber-700 flex items-center gap-2">
                        <i data-lucide="flag" class="w-4 h-4"></i>
                        1. Detail Kegiatan Komunal
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form.field label="Nama Acara / Kegiatan Olahraga" name="nama_aktivitas" :required="true">
                            <x-form.input wire:model="nama_aktivitas" placeholder="Contoh: Senam Minggu Pagi RW 05" />
                        </x-form.field>
                        <x-form.field label="Induk Olahraga (INORGA)" name="inorga_id">
                            <x-form.select wire:model="inorga_id">
                                <option value="">-- Pilih Inorga --</option>
                                @foreach($daftarInorga as $ino)
                                    <option value="{{ $ino->id }}">{{ $ino->nama_inorga }} ({{ $ino->singkatan }})</option>
                                @endforeach
                            </x-form.select>
                        </x-form.field>
                    </div>
                </div>

                <!-- 2. Jumlah Partisipan -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <h3 class="text-xs font-black uppercase tracking-wider text-amber-700 flex items-center gap-2">
                        <i data-lucide="users" class="w-4 h-4"></i>
                        2. Estimasi Jumlah Warga yang Mengikuti
                    </h3>
                    <div>
                        <x-form.label value="Jumlah Partisipan (Orang)" :required="true" />
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            @foreach([10, 25, 50, 100, 200, 500] as $peserta)
                                <button 
                                    type="button" 
                                    wire:click="setPeserta({{ $peserta }})"
                                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition cursor-pointer {{ $jumlah_peserta === $peserta ? 'bg-amber-600 text-white shadow-md shadow-amber-600/20' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}"
                                >
                                    {{ $peserta }} Orang
                                </button>
                            @endforeach
                        </div>
                        <x-form.input type="number" wire:model="jumlah_peserta" min="2" max="5000" placeholder="Ketik jumlah peserta" />
                    </div>
                </div>

                <!-- 3. Waktu & Lokasi -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <h3 class="text-xs font-black uppercase tracking-wider text-amber-700 flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                        3. Waktu & Lokasi Wilayah
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form.field label="Tanggal Kegiatan" name="tanggal_aktivitas" :required="true">
                            <x-form.input type="date" wire:model="tanggal_aktivitas" max="{{ now()->toDateString() }}" />
                        </x-form.field>
                        <x-form.field label="Durasi (Menit)" name="durasi_menit" :required="true">
                            <x-form.input type="number" wire:model="durasi_menit" min="15" max="360" />
                        </x-form.field>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form.field label="Kecamatan" name="kecamatan_id" :required="true">
                            <x-form.select wire:model.live="kecamatan_id">
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach($daftarKecamatan as $kec)
                                    <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                                @endforeach
                            </x-form.select>
                        </x-form.field>
                        <x-form.field label="Desa / Kelurahan" name="desa_kelurahan_id">
                            <x-form.select wire:model="desa_kelurahan_id" :disabled="!$kecamatan_id">
                                <option value="">-- Pilih Desa / Kelurahan --</option>
                                @foreach($daftarDesa as $des)
                                    <option value="{{ $des->id }}">{{ $des->nama_desa_kelurahan }}</option>
                                @endforeach
                            </x-form.select>
                        </x-form.field>
                    </div>
                    <x-form.field label="Nama Lokasi / Lapangan" name="nama_tempat" :required="true">
                        <x-form.input wire:model="nama_tempat" placeholder="Contoh: Lapangan Sepak Bola Desa Soreang" />
                    </x-form.field>
                </div>

                <!-- 4. Dokumentasi Bukti -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <h3 class="text-xs font-black uppercase tracking-wider text-amber-700 flex items-center gap-2">
                        <i data-lucide="camera" class="w-4 h-4"></i>
                        4. Dokumentasi Foto Lapangan (Wajib untuk Duta)
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-form.field label="Foto Keramaian / Suasana Kegiatan" name="foto_kegiatan" :required="true">
                                <input type="file" wire:model="foto_kegiatan" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 cursor-pointer">
                            </x-form.field>
                            @if($foto_kegiatan)
                                <div class="mt-2 rounded-2xl overflow-hidden border border-amber-200 bg-slate-50 p-2 inline-block">
                                    <img src="{{ $foto_kegiatan->temporaryUrl() }}" alt="Preview" class="h-32 w-auto rounded-xl object-cover">
                                </div>
                            @endif
                        </div>
                        <div>
                            <x-form.field label="Foto Daftar Hadir / Spanduk (Opsional)" name="foto_daftar_hadir">
                                <input type="file" wire:model="foto_daftar_hadir" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">
                            </x-form.field>
                            @if($foto_daftar_hadir)
                                <div class="mt-2 rounded-2xl overflow-hidden border border-slate-200 bg-slate-50 p-2 inline-block">
                                    <img src="{{ $foto_daftar_hadir->temporaryUrl() }}" alt="Preview" class="h-32 w-auto rounded-xl object-cover">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        class="w-full sm:w-auto px-8 py-3 rounded-2xl bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-black text-xs uppercase tracking-wider transition shadow-lg shadow-amber-600/25 cursor-pointer disabled:opacity-50"
                    >
                        <span wire:loading.remove>Kirim Laporan Duta Olahraga</span>
                        <span wire:loading>Mengirim Data...</span>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
