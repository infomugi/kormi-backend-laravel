{{-- Langkah 1: identitas responden --}}
<div class="kd-subhead">
    <h4>Identitas Responden</h4>
    <span class="kd-chip">Bagian 1</span>
</div>

<div class="kd-group">
    <div class="kd-label-row">
        <label class="kd-label" for="m-angket-nama"><span class="kd-qnum">1</span> Nama Lengkap <span class="kd-req">*</span></label>
    </div>
    <div class="kd-control">
        <input type="text" id="m-angket-nama" wire:model="nama_lengkap" class="kd-input" placeholder="Nama lengkap" autocomplete="name">
    </div>
    @error('nama_lengkap')<p class="kd-error">{{ $message }}</p>@enderror
</div>

<div class="kd-row-2">
    <div class="kd-group">
        <div class="kd-label-row">
            <label class="kd-label" for="m-angket-usia"><span class="kd-qnum">2</span> Usia (tahun) <span class="kd-req">*</span></label>
        </div>
        <div class="kd-control">
            <input type="number" id="m-angket-usia" wire:model="usia" class="kd-input" placeholder="35" inputmode="numeric" min="10" max="100">
        </div>
        @error('usia')<p class="kd-error">{{ $message }}</p>@enderror
    </div>

    <div class="kd-group">
        <div class="kd-label-row">
            <label class="kd-label"><span class="kd-qnum">3</span> Jenis Kelamin <span class="kd-req">*</span></label>
        </div>
        <div class="kd-choice-row">
            <label class="kd-choice kd-choice--compact">
                <input type="radio" id="jenis_kelamin-pria" wire:model="jenis_kelamin" value="pria">
                <span class="kd-choice-dot"></span>
                <span>Pria</span>
            </label>
            <label class="kd-choice kd-choice--compact">
                <input type="radio" id="jenis_kelamin-wanita" wire:model="jenis_kelamin" value="wanita">
                <span class="kd-choice-dot"></span>
                <span>Wanita</span>
            </label>
        </div>
        @error('jenis_kelamin')<p class="kd-error">{{ $message }}</p>@enderror
    </div>
</div>

<div class="kd-label-row" style="margin-bottom: 7px;">
    <span class="kd-label"><span class="kd-qnum">4</span> Tinggi &amp; Berat Badan <span class="kd-optional">Opsional</span></span>
</div>
<div class="kd-row-2">
    <div class="kd-group" style="margin-bottom: 14px;">
        <div class="kd-control">
            <input type="number" id="m-angket-tinggi" wire:model="tinggi_badan" class="kd-input" placeholder="Tinggi (cm)" inputmode="numeric" min="80" max="250">
        </div>
        @error('tinggi_badan')<p class="kd-error">{{ $message }}</p>@enderror
    </div>
    <div class="kd-group" style="margin-bottom: 14px;">
        <div class="kd-control">
            <input type="number" id="m-angket-berat" wire:model="berat_badan" class="kd-input" placeholder="Berat (kg)" inputmode="numeric" min="20" max="300">
        </div>
        @error('berat_badan')<p class="kd-error">{{ $message }}</p>@enderror
    </div>
</div>

<div class="kd-group">
    <div class="kd-label-row">
        <label class="kd-label" for="m-angket-alamat"><span class="kd-qnum">5</span> Alamat Lengkap <span class="kd-req">*</span></label>
    </div>
    <div class="kd-control">
        <textarea id="m-angket-alamat" wire:model="alamat" class="kd-textarea" placeholder="Nama jalan, RT/RW, desa/kelurahan"></textarea>
    </div>
    @error('alamat')<p class="kd-error">{{ $message }}</p>@enderror
</div>

<div class="kd-group">
    <div class="kd-label-row">
        <label class="kd-label" for="m-angket-kecamatan">Kecamatan <span class="kd-req">*</span></label>
    </div>
    <div class="kd-control">
        <select id="m-angket-kecamatan" wire:model.live="kecamatan_id" class="kd-select">
            <option value="">-- Pilih kecamatan --</option>
            @foreach($daftarKecamatan as $kecamatan)
                <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama_kecamatan }}</option>
            @endforeach
        </select>
        <span class="kd-icon"><i data-lucide="chevron-down"></i></span>
    </div>
    @error('kecamatan_id')<p class="kd-error">{{ $message }}</p>@enderror
</div>

<div class="kd-group">
    <div class="kd-label-row">
        <label class="kd-label" for="m-angket-desa">Desa/Kelurahan <span class="kd-req">*</span></label>
    </div>
    <div class="kd-control">
        <select id="m-angket-desa" wire:model="desa_kelurahan_id" class="kd-select" @disabled(! $kecamatan_id)>
            <option value="">{{ $kecamatan_id ? '-- Pilih desa/kelurahan --' : '-- Pilih kecamatan dulu --' }}</option>
            @foreach($daftarDesa as $desa)
                <option value="{{ $desa->id }}">{{ $desa->nama_desa_kelurahan }}</option>
            @endforeach
        </select>
        <span class="kd-icon"><i data-lucide="chevron-down"></i></span>
    </div>
    @error('desa_kelurahan_id')<p class="kd-error">{{ $message }}</p>@enderror
</div>

<div class="kd-group">
    <div class="kd-label-row">
        <label class="kd-label" for="m-angket-kabupaten">Kabupaten/Kota</label>
    </div>
    <div class="kd-control">
        <input type="text" id="m-angket-kabupaten" class="kd-input kd-input--locked" value="{{ $kabupaten_kota }}" readonly aria-readonly="true">
        <span class="kd-icon"><i data-lucide="lock"></i></span>
    </div>
</div>

<div class="kd-group">
    <div class="kd-label-row">
        <label class="kd-label" for="m-angket-pekerjaan"><span class="kd-qnum">6</span> Pekerjaan Sekarang <span class="kd-req">*</span></label>
    </div>
    <div class="kd-control">
        <select id="m-angket-pekerjaan" wire:model.live="pekerjaan" class="kd-select">
            <option value="">-- Pilih pekerjaan --</option>
            @foreach($opsiPekerjaan as $nilai => $label)
                <option value="{{ $nilai }}">{{ $label }}</option>
            @endforeach
        </select>
        <span class="kd-icon"><i data-lucide="chevron-down"></i></span>
    </div>
    @error('pekerjaan')<p class="kd-error">{{ $message }}</p>@enderror
</div>

@if($pekerjaan === 'lainnya')
    <div class="kd-group">
        <div class="kd-label-row">
            <label class="kd-label" for="m-angket-pekerjaan-lain">Sebutkan Pekerjaan <span class="kd-req">*</span></label>
        </div>
        <div class="kd-control">
            <input type="text" id="m-angket-pekerjaan-lain" wire:model="pekerjaan_lainnya" class="kd-input" placeholder="Pekerjaan Anda">
        </div>
        @error('pekerjaan_lainnya')<p class="kd-error">{{ $message }}</p>@enderror
    </div>
@endif
