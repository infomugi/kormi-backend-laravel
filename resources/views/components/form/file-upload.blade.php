@props([
    'upload' => null,
    'savedPath' => null,
    'name' => 'uploadBerkas',
    'inputId' => 'fileDropzoneInput_' . rand(1000, 9999),
    'accept' => '.pdf,.doc,.docx,.xls,.xlsx,.zip,.rar',
    'maxSizeMB' => 10,
    'title' => 'Unggah Dokumen Berkas',
    'subtitle' => 'PDF, DOCX, XLSX, ZIP (Maksimal 10MB)',
])

<div 
    x-data="{
        isDragging: false,
        handleFiles(files) {
            if (!files || files.length === 0) return;
            const file = files[0];

            @this.upload('{{ $name }}', file, 
                () => { this.isDragging = false; }, 
                () => { this.isDragging = false; }
            );
        }
    }"
    class="space-y-2.5 w-full"
>
    <!-- Dropzone Box for Generic Files -->
    <div 
        @dragover.prevent="isDragging = true"
        @dragleave.prevent="isDragging = false"
        @drop.prevent="isDragging = false; handleFiles($event.dataTransfer.files)"
        @click="$refs.genericFileInput.click()"
        class="w-full p-4 sm:p-5 rounded-xl sm:rounded-2xl border-2 border-dashed transition-all duration-200 relative flex flex-col items-center justify-center cursor-pointer group select-none text-center"
        :class="isDragging ? 'border-emerald-500 bg-emerald-50/70 scale-[0.99] ring-4 ring-emerald-500/10' : '{{ $upload ? 'border-emerald-500 bg-emerald-50/20' : 'border-slate-200/90 bg-slate-50/60 hover:bg-slate-100/70 hover:border-emerald-400/80' }}'"
    >
        @if($upload)
            <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center mx-auto mb-2 shadow-sm">
                <i data-lucide="file-check" class="w-5 h-5"></i>
            </div>
            <p class="text-xs font-black text-emerald-950 truncate max-w-full px-2">{{ $upload->getClientOriginalName() }}</p>
            <p class="text-[10px] text-emerald-700 mt-0.5 font-bold">&#10003; {{ round($upload->getSize() / 1024, 1) }} KB Siap Diunggah</p>
        @elseif($savedPath)
            <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center mx-auto mb-2 shadow-sm">
                <i data-lucide="file-text" class="w-5 h-5 text-emerald-400"></i>
            </div>
            <p class="text-xs font-black text-slate-800 truncate max-w-full px-2">{{ basename($savedPath) }}</p>
            <p class="text-[10px] text-slate-400 mt-0.5">Berkas Tersimpan di Server</p>
        @else
            <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-emerald-600 flex items-center justify-center mx-auto mb-2 shadow-2xs group-hover:scale-110 transition-transform">
                <i data-lucide="folder-up" class="w-4.5 h-4.5"></i>
            </div>
            <p class="text-xs font-bold text-slate-700 group-hover:text-emerald-700 transition-colors">{{ $title }}</p>
            <p class="text-[10px] text-slate-400 mt-0.5">{{ $subtitle }}</p>
        @endif
    </div>

    <!-- Hidden Native File Input -->
    <input 
        x-ref="genericFileInput" 
        id="{{ $inputId }}" 
        type="file" 
        accept="{{ $accept }}" 
        @change="handleFiles($event.target.files)"
        class="hidden"
    >

    @if($upload)
        <div class="flex items-center justify-end px-1">
            <button 
                type="button" 
                wire:click="$set('{{ $name }}', null)" 
                class="text-[11px] text-rose-600 hover:text-rose-800 font-bold hover:underline cursor-pointer"
            >
                Hapus Berkas
            </button>
        </div>
    @endif

    @error($name)
        <span class="text-xs text-rose-600 block font-bold flex items-center gap-1">
            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
            <span>{{ $message }}</span>
        </span>
    @enderror
</div>
