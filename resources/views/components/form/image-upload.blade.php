@props([
    'upload' => null,
    'savedPath' => null,
    'name' => 'uploadGambar',
    'inputId' => 'uploadDropzoneInput_' . rand(1000, 9999),
    'accept' => 'image/jpeg,image/png,image/webp',
    'maxSizeMB' => 2,
    'placeholderText' => 'Seret & lepas foto di sini, atau telusuri berkas',
    'emptyTitle' => 'Unggah Foto Utama',
    'emptySubtitle' => 'Format JPG, PNG, WEBP (Otomatis kompres jika > 2MB)',
    'aspectRatio' => 'h-36 sm:h-44',
])

<div 
    x-data="{
        isDragging: false,
        isCompressing: false,
        compressionInfo: null,
        async handleFiles(files) {
            if (!files || files.length === 0) return;
            let file = files[0];

            if (file.type.startsWith('image/') && file.size > ({{ $maxSizeMB }} * 1024 * 1024)) {
                this.isCompressing = true;
                const originalSize = file.size;
                
                try {
                    if (window.compressImageClientSide) {
                        file = await window.compressImageClientSide(file, {
                            maxSizeMB: {{ $maxSizeMB }},
                            maxWidthOrHeight: 1920,
                            initialQuality: 0.85
                        });
                        
                        const savedPercent = Math.round((1 - (file.size / originalSize)) * 100);
                        this.compressionInfo = `Telah dikompres ${savedPercent}% (${(originalSize/1024/1024).toFixed(1)}MB &rarr; ${(file.size/1024).toFixed(0)}KB)`;
                    }
                } catch (e) {
                    console.warn('Kompresi gagal, melanjutkan upload asli:', e);
                } finally {
                    this.isCompressing = false;
                }
            } else {
                this.compressionInfo = null;
            }

            // Upload to Livewire
            @this.upload('{{ $name }}', file, 
                (uploadedFilename) => {
                    this.isDragging = false;
                }, 
                () => {
                    this.isDragging = false;
                    this.isCompressing = false;
                }
            );
        }
    }"
    class="space-y-2.5 w-full"
>
    <!-- Dropzone Box -->
    <div 
        @dragover.prevent="isDragging = true"
        @dragleave.prevent="isDragging = false"
        @drop.prevent="isDragging = false; handleFiles($event.dataTransfer.files)"
        @click="$refs.fileInput.click()"
        class="w-full {{ $aspectRatio }} rounded-xl sm:rounded-2xl overflow-hidden border-2 border-dashed transition-all duration-200 relative flex items-center justify-center cursor-pointer group select-none"
        :class="isDragging ? 'border-emerald-500 bg-emerald-50/70 scale-[0.99] ring-4 ring-emerald-500/10' : '{{ $upload ? 'border-emerald-500 bg-emerald-50/20' : 'border-slate-200/90 bg-slate-50/60 hover:bg-slate-100/70 hover:border-emerald-400/80' }}'"
    >
        @if($upload)
            <img src="{{ $upload->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview Unggahan">
            <div class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-2xs">
                <span class="px-3 py-1.5 rounded-xl bg-white/95 text-slate-900 text-xs font-black shadow-lg flex items-center gap-1.5">
                    <i data-lucide="refresh-cw" class="w-3.5 h-3.5 text-emerald-600"></i>
                    <span>Ganti Foto</span>
                </span>
            </div>
            <div class="absolute bottom-2 right-2 bg-emerald-600/90 text-white text-[10px] font-bold px-2 py-0.5 rounded-lg shadow-xs flex items-center gap-1 backdrop-blur-xs">
                <i data-lucide="check" class="w-3 h-3"></i>
                <span>Siap Unggah</span>
            </div>
        @elseif($savedPath)
            @php $tmpUrl = app(\App\Services\StorageService::class)->getTemporaryUrl($savedPath) ?? $savedPath @endphp
            <img src="{{ $tmpUrl }}" class="w-full h-full object-cover" alt="Gambar Tersimpan">
            <div class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-2xs">
                <span class="px-3 py-1.5 rounded-xl bg-white/95 text-slate-900 text-xs font-black shadow-lg flex items-center gap-1.5">
                    <i data-lucide="refresh-cw" class="w-3.5 h-3.5 text-emerald-600"></i>
                    <span>Ganti Foto</span>
                </span>
            </div>
            <div class="absolute bottom-2 right-2 bg-slate-900/80 text-white text-[10px] font-bold px-2 py-0.5 rounded-lg backdrop-blur-xs flex items-center gap-1">
                <i data-lucide="hard-drive" class="w-3 h-3"></i>
                <span>Tersimpan</span>
            </div>
        @else
            <div class="text-center p-3 sm:p-4">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-white border border-slate-200 text-emerald-600 flex items-center justify-center mx-auto mb-1.5 shadow-2xs group-hover:scale-110 transition-transform">
                    <i data-lucide="upload-cloud" class="w-4 h-4 sm:w-4.5 sm:h-4.5"></i>
                </div>
                <p class="text-xs font-bold text-slate-700 group-hover:text-emerald-700 transition-colors">{{ $emptyTitle }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5">{{ $emptySubtitle }}</p>
            </div>
        @endif

        <!-- Compressing Overlay Spinner -->
        <div 
            x-show="isCompressing" 
            x-transition.opacity 
            class="absolute inset-0 bg-white/90 backdrop-blur-xs flex flex-col items-center justify-center gap-2 z-20"
            style="display: none;"
        >
            <div class="w-7 h-7 border-2 border-emerald-600 border-t-transparent rounded-full animate-spin"></div>
            <p class="text-xs font-black text-emerald-950">Mengompres Foto...</p>
            <p class="text-[10px] text-slate-500">Merapikan ukuran ke &le; {{ $maxSizeMB }}MB secara instan</p>
        </div>
    </div>

    <!-- Hidden Native File Input -->
    <input 
        x-ref="fileInput" 
        id="{{ $inputId }}" 
        type="file" 
        accept="{{ $accept }}" 
        @change="handleFiles($event.target.files)"
        class="hidden"
    >

    <!-- Upload Info & Live Compression Feedback -->
    <div class="flex items-center justify-between text-[11px] px-0.5">
        <template x-if="compressionInfo">
            <span class="text-emerald-700 font-bold flex items-center gap-1 bg-emerald-50 border border-emerald-200/60 px-2 py-0.5 rounded-md" x-html="'&#10003; ' + compressionInfo"></span>
        </template>
        
        @if($upload)
            <div class="flex items-center justify-between w-full text-[11px] text-slate-500 font-medium">
                <span class="font-bold text-emerald-800 truncate pr-2">&#10003; {{ round($upload->getSize() / 1024, 1) }} KB siap</span>
                <button 
                    type="button" 
                    wire:click="$set('{{ $name }}', null)" 
                    class="text-rose-600 hover:text-rose-800 font-bold hover:underline cursor-pointer shrink-0"
                >
                    Hapus Foto
                </button>
            </div>
        @endif
    </div>

    @error($name)
        <span class="text-xs text-rose-600 block font-bold flex items-center gap-1">
            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
            <span>{{ $message }}</span>
        </span>
    @enderror
</div>
