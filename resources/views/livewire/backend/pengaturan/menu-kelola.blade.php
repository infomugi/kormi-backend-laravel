<div class="space-y-6">

    <!-- ========================================================================= -->
    <!-- HEADER CMS                                                                -->
    <!-- ========================================================================= -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden">
        <div class="space-y-1 relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider">
                <i data-lucide="menu" class="w-3.5 h-3.5"></i>
                <span>Pengaturan Navigasi</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen Menu Navigasi</h1>
            <p class="text-sm text-slate-500 font-medium">
                Atur struktur menu frontend & backend, urutan (drag & drop / panah), edit langsung di tabel (inline), dan duplikasi menu dalam 1 klik.
            </p>
        </div>

        <div class="flex items-center gap-2.5 relative z-10 flex-wrap">
            <button 
                type="button" 
                wire:click="resetKeDefault" 
                wire:confirm="Apakah Anda yakin ingin memulihkan susunan menu bawaan sistem untuk grup ini? Perubahan kustom akan ditimpa."
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer"
            >
                <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                <span>Pulihkan Default</span>
            </button>

            <button 
                type="button" 
                wire:click="bukaModalTambah" 
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 via-emerald-600 to-teal-700 hover:from-emerald-500 hover:to-teal-600 text-white font-extrabold text-xs uppercase tracking-wider shadow-lg shadow-emerald-600/20 hover:shadow-emerald-600/35 active:scale-95 transition-all cursor-pointer"
            >
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Tambah Menu Baru</span>
            </button>
        </div>

        <!-- Ambient Decoration -->
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    <!-- FLASH NOTIFICATIONS -->
    @if (session()->has('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-3 animate-in fade-in duration-200 shadow-xs">
            <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                <i data-lucide="check" class="w-3.5 h-3.5 stroke-[3]"></i>
            </div>
            <span class="flex-1">{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('info'))
        <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200 text-blue-800 text-xs font-semibold flex items-center gap-3 animate-in fade-in duration-200 shadow-xs">
            <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                <i data-lucide="info" class="w-3.5 h-3.5 stroke-[3]"></i>
            </div>
            <span class="flex-1">{{ session('info') }}</span>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- LOCATION TABS & CONTROLS                                                  -->
    <!-- ========================================================================= -->
    <div class="bg-white rounded-3xl p-4 sm:p-6 border border-slate-100 shadow-sm space-y-5">
        
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 pb-4 border-b border-slate-100">
            <!-- Group Tabs -->
            <div class="flex items-center gap-2 p-1.5 bg-slate-100/80 rounded-2xl overflow-x-auto">
                <button 
                    type="button" 
                    wire:click="setGrup('frontend_header')" 
                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all whitespace-nowrap {{ $grup === 'frontend_header' ? 'bg-white text-emerald-800 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}"
                >
                    <i data-lucide="layout-template" class="w-4 h-4 {{ $grup === 'frontend_header' ? 'text-emerald-600' : 'text-slate-400' }}"></i>
                    <span>Frontend Navbar</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $grup === 'frontend_header' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700' }}">
                        {{ \App\Models\Core\Menu::grup('frontend_header')->count() }}
                    </span>
                </button>

                <button 
                    type="button" 
                    wire:click="setGrup('frontend_footer')" 
                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all whitespace-nowrap {{ $grup === 'frontend_footer' ? 'bg-white text-emerald-800 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}"
                >
                    <i data-lucide="panel-bottom" class="w-4 h-4 {{ $grup === 'frontend_footer' ? 'text-emerald-600' : 'text-slate-400' }}"></i>
                    <span>Frontend Footer</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $grup === 'frontend_footer' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700' }}">
                        {{ \App\Models\Core\Menu::grup('frontend_footer')->count() }}
                    </span>
                </button>

                <button 
                    type="button" 
                    wire:click="setGrup('backend_sidebar')" 
                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all whitespace-nowrap {{ $grup === 'backend_sidebar' ? 'bg-white text-emerald-800 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}"
                >
                    <i data-lucide="sidebar" class="w-4 h-4 {{ $grup === 'backend_sidebar' ? 'text-emerald-600' : 'text-slate-400' }}"></i>
                    <span>Backend Sidebar CMS</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $grup === 'backend_sidebar' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700' }}">
                        {{ \App\Models\Core\Menu::grup('backend_sidebar')->count() }}
                    </span>
                </button>
            </div>

            <!-- Search & Filters -->
            <div class="flex items-center gap-3">
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="pencarian" 
                        placeholder="Cari menu / link..." 
                        class="w-full h-10 pl-9 pr-3 text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-600 focus:outline-none transition-all"
                    >
                </div>
            </div>
        </div>

        <!-- BULK ACTIONS BAR (When selected) -->
        @if(count($selectedIds) > 0)
            <div class="p-3.5 rounded-2xl bg-emerald-50/80 border border-emerald-200 flex flex-wrap items-center justify-between gap-3 animate-in fade-in duration-200">
                <div class="flex items-center gap-2 text-xs font-bold text-emerald-900">
                    <i data-lucide="check-square" class="w-4 h-4 text-emerald-600"></i>
                    <span>{{ count($selectedIds) }} menu terpilih</span>
                </div>
                <div class="flex items-center gap-2">
                    <button 
                        type="button" 
                        wire:click="bulkToggleStatus(true)" 
                        class="px-3 py-1.5 rounded-xl bg-white border border-emerald-200 hover:bg-emerald-100 text-emerald-800 text-xs font-bold transition-colors cursor-pointer"
                    >
                        Aktifkan
                    </button>
                    <button 
                        type="button" 
                        wire:click="bulkToggleStatus(false)" 
                        class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-bold transition-colors cursor-pointer"
                    >
                        Nonaktifkan
                    </button>
                    <button 
                        type="button" 
                        wire:click="bulkHapus" 
                        wire:confirm="Yakin ingin menghapus seluruh menu yang dipilih?"
                        class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-colors cursor-pointer"
                    >
                        Hapus Terpilih
                    </button>
                </div>
            </div>
        @endif

        <!-- TIPS BAR -->
        <div class="flex items-center justify-between text-xs text-slate-500 bg-slate-50/70 px-4 py-2.5 rounded-2xl border border-slate-100">
            <div class="flex items-center gap-2">
                <i data-lucide="sparkles" class="w-4 h-4 text-amber-500"></i>
                <span class="font-medium">
                    <strong class="text-slate-700">Fitur Cepat:</strong> Anda dapat mengedit teks Nama, URL, Icon, & Urutan langsung di tabel (inline edit), klik tombol <strong>Duplikat</strong> untuk menggandakan menu, atau gunakan panah atas/bawah untuk reordering.
                </span>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- MENU LIST / TREE TABLE                                                    -->
        <!-- ========================================================================= -->
        <div 
            class="space-y-3"
            x-data="{
                draggedId: null,
                initDragAndDrop() {
                    // Native HTML5 Drag and Drop handler
                },
                onDragStart(e, id) {
                    this.draggedId = id;
                    e.dataTransfer.effectAllowed = 'move';
                    e.dataTransfer.setData('text/plain', id);
                },
                onDragOver(e) {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                },
                onDrop(e, targetId) {
                    e.preventDefault();
                    if (!this.draggedId || this.draggedId === targetId) return;
                    
                    const rows = Array.from(document.querySelectorAll('[data-menu-id]'));
                    const ids = rows.map(el => el.getAttribute('data-menu-id'));
                    const fromIndex = ids.indexOf(this.draggedId);
                    const toIndex = ids.indexOf(targetId);
                    
                    if (fromIndex !== -1 && toIndex !== -1) {
                        ids.splice(fromIndex, 1);
                        ids.splice(toIndex, 0, this.draggedId);
                        $wire.updateUrutan(ids);
                    }
                    this.draggedId = null;
                }
            }"
        >
            @forelse($menus as $menu)
                <!-- PARENT ITEM ROW -->
                <div 
                    data-menu-id="{{ $menu->id }}"
                    draggable="true"
                    @dragstart="onDragStart($event, '{{ $menu->id }}')"
                    @dragover="onDragOver($event)"
                    @drop="onDrop($event, '{{ $menu->id }}')"
                    class="group bg-white border border-slate-200/90 hover:border-emerald-500/60 rounded-2xl p-3.5 sm:p-4 transition-all shadow-xs hover:shadow-md relative {{ !$menu->status_aktif ? 'opacity-65 bg-slate-50/50' : '' }}"
                >
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                        
                        <!-- Left: Drag Handle, Select, Icon, Inline Name & URL -->
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <!-- Drag Handle -->
                            <div class="cursor-grab active:cursor-grabbing text-slate-300 hover:text-slate-600 p-1 rounded transition-colors" title="Tarik untuk memindahkan urutan">
                                <i data-lucide="grip-vertical" class="w-4 h-4"></i>
                            </div>

                            <!-- Selection Checkbox -->
                            <input 
                                type="checkbox" 
                                value="{{ $menu->id }}" 
                                wire:model.live="selectedIds"
                                class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 transition-colors cursor-pointer shrink-0"
                            >

                            <!-- Icon Preview / Badge -->
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 border border-emerald-200/60 text-emerald-700 flex items-center justify-center shrink-0 shadow-2xs">
                                @if($menu->icon)
                                    <i data-lucide="{{ $menu->icon }}" class="w-4 h-4"></i>
                                @else
                                    <i data-lucide="link" class="w-4 h-4"></i>
                                @endif
                            </div>

                            <!-- Inline Inputs Container -->
                            <div class="flex-1 grid grid-cols-1 sm:grid-cols-12 gap-2 min-w-0 items-center">
                                
                                <!-- Nama Menu (Inline Edit) -->
                                <div class="sm:col-span-5">
                                    <input 
                                        type="text" 
                                        value="{{ $menu->nama }}" 
                                        wire:change="updateInline('{{ $menu->id }}', 'nama', $event.target.value)"
                                        title="Klik untuk mengubah nama menu langsung"
                                        class="w-full text-xs sm:text-sm font-black text-slate-900 bg-transparent hover:bg-slate-50 focus:bg-white border border-transparent hover:border-slate-200 focus:border-emerald-600 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 transition-all truncate"
                                    >
                                </div>

                                <!-- Tautan / URL (Inline Edit) -->
                                <div class="sm:col-span-4">
                                    <input 
                                        type="text" 
                                        value="{{ $menu->tautan }}" 
                                        wire:change="updateInline('{{ $menu->id }}', 'tautan', $event.target.value)"
                                        title="Klik untuk mengubah URL/Route langsung"
                                        class="w-full text-xs font-medium text-slate-500 bg-transparent hover:bg-slate-50 focus:bg-white border border-transparent hover:border-slate-200 focus:border-emerald-600 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 transition-all truncate font-mono"
                                    >
                                </div>

                                <!-- Target / Badge Indicators -->
                                <div class="sm:col-span-3 flex items-center gap-1.5">
                                    @if($menu->target === '_blank')
                                        <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 text-[10px] font-bold border border-amber-200" title="Buka di tab baru">
                                            _blank
                                        </span>
                                    @endif
                                    @if($menu->badge)
                                        <span class="px-2 py-0.5 rounded-md bg-lime-100 text-lime-800 text-[10px] font-black uppercase">
                                            {{ $menu->badge }}
                                        </span>
                                    @endif
                                    @if($menu->anak && $menu->anak->count() > 0)
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">
                                            {{ $menu->anak->count() }} Sub-menu
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right: Urutan, Quick Move, Status Toggle, Actions -->
                        <div class="flex items-center gap-2 shrink-0 self-end md:self-center">
                            
                            <!-- Urutan Input -->
                            <div class="flex items-center gap-1 bg-slate-100 px-2 py-1 rounded-xl">
                                <span class="text-[10px] font-bold text-slate-400">#</span>
                                <input 
                                    type="number" 
                                    value="{{ $menu->urutan }}" 
                                    wire:change="updateInline('{{ $menu->id }}', 'urutan', $event.target.value)"
                                    class="w-10 text-xs font-black text-center bg-transparent border-0 p-0 focus:outline-none focus:ring-0"
                                    title="Ubah nomor urutan"
                                >
                            </div>

                            <!-- Move Up / Down Buttons -->
                            <div class="flex items-center gap-0.5 bg-slate-100 p-0.5 rounded-xl">
                                <button 
                                    type="button" 
                                    wire:click="pindahUrutan('{{ $menu->id }}', 'atas')" 
                                    class="p-1 text-slate-500 hover:text-emerald-700 hover:bg-white rounded-lg transition-colors cursor-pointer"
                                    title="Pindahkan Ke Atas"
                                >
                                    <i data-lucide="arrow-up" class="w-3.5 h-3.5"></i>
                                </button>
                                <button 
                                    type="button" 
                                    wire:click="pindahUrutan('{{ $menu->id }}', 'bawah')" 
                                    class="p-1 text-slate-500 hover:text-emerald-700 hover:bg-white rounded-lg transition-colors cursor-pointer"
                                    title="Pindahkan Ke Bawah"
                                >
                                    <i data-lucide="arrow-down" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>

                            <!-- Status Toggle Button -->
                            <button 
                                type="button" 
                                wire:click="toggleAktif('{{ $menu->id }}')" 
                                class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl text-xs font-bold transition-colors cursor-pointer {{ $menu->status_aktif ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}"
                                title="Klik untuk mengaktifkan / menonaktifkan menu"
                            >
                                <span class="w-2 h-2 rounded-full {{ $menu->status_aktif ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                <span>{{ $menu->status_aktif ? 'Aktif' : 'Nonaktif' }}</span>
                            </button>

                            <!-- Add Submenu Button -->
                            <button 
                                type="button" 
                                wire:click="bukaModalTambah('{{ $menu->id }}')" 
                                class="p-2 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 transition-colors cursor-pointer"
                                title="Tambah Sub-Menu di bawah {{ $menu->nama }}"
                            >
                                <i data-lucide="corner-down-right" class="w-4 h-4"></i>
                            </button>

                            <!-- Clone / Duplicate Button -->
                            <button 
                                type="button" 
                                wire:click="duplikatMenu('{{ $menu->id }}')" 
                                class="p-2 rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-600 hover:text-blue-700 transition-colors cursor-pointer"
                                title="Duplikat / Clone Menu Ini"
                            >
                                <i data-lucide="copy" class="w-4 h-4"></i>
                            </button>

                            <!-- Edit Button -->
                            <button 
                                type="button" 
                                wire:click="bukaModalEdit('{{ $menu->id }}')" 
                                class="p-2 rounded-xl bg-slate-100 hover:bg-amber-50 text-slate-600 hover:text-amber-700 transition-colors cursor-pointer"
                                title="Edit Detail Menu"
                            >
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>

                            <!-- Delete Button -->
                            <button 
                                type="button" 
                                wire:click="hapus('{{ $menu->id }}')" 
                                wire:confirm="Apakah Anda yakin ingin menghapus menu '{{ $menu->nama }}' beserta sub-menunya?"
                                class="p-2 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 transition-colors cursor-pointer"
                                title="Hapus Menu"
                            >
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <!-- ========================================================================= -->
                    <!-- SUB-MENUS (CHILDREN) TREE                                                 -->
                    <!-- ========================================================================= -->
                    @if($menu->anak && $menu->anak->count() > 0)
                        <div class="mt-3 pt-3 border-t border-slate-100 pl-4 sm:pl-8 space-y-2 border-l-2 border-emerald-500/30 ml-2">
                            @foreach($menu->anak as $sub)
                                <div 
                                    data-menu-id="{{ $sub->id }}"
                                    class="bg-slate-50/80 hover:bg-white border border-slate-200/70 hover:border-emerald-400/80 rounded-xl p-2.5 sm:p-3 transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-2 {{ !$sub->status_aktif ? 'opacity-65' : '' }}"
                                >
                                    <div class="flex items-center gap-2.5 flex-1 min-w-0">
                                        <div class="text-slate-400">
                                            <i data-lucide="corner-down-right" class="w-3.5 h-3.5 text-emerald-600"></i>
                                        </div>

                                        <input 
                                            type="checkbox" 
                                            value="{{ $sub->id }}" 
                                            wire:model.live="selectedIds"
                                            class="w-3.5 h-3.5 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 transition-colors cursor-pointer shrink-0"
                                        >

                                        <div class="w-7 h-7 rounded-lg bg-white border border-slate-200 text-emerald-600 flex items-center justify-center shrink-0">
                                            @if($sub->icon)
                                                <i data-lucide="{{ $sub->icon }}" class="w-3.5 h-3.5"></i>
                                            @else
                                                <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                                            @endif
                                        </div>

                                        <!-- Inline Submenu Name -->
                                        <div class="flex-1 grid grid-cols-1 sm:grid-cols-12 gap-2 min-w-0 items-center">
                                            <div class="sm:col-span-6">
                                                <input 
                                                    type="text" 
                                                    value="{{ $sub->nama }}" 
                                                    wire:change="updateInline('{{ $sub->id }}', 'nama', $event.target.value)"
                                                    class="w-full text-xs font-bold text-slate-800 bg-transparent hover:bg-white focus:bg-white border border-transparent hover:border-slate-200 focus:border-emerald-600 rounded-lg px-2 py-0.5 focus:outline-none transition-all truncate"
                                                >
                                            </div>
                                            <div class="sm:col-span-6">
                                                <input 
                                                    type="text" 
                                                    value="{{ $sub->tautan }}" 
                                                    wire:change="updateInline('{{ $sub->id }}', 'tautan', $event.target.value)"
                                                    class="w-full text-[11px] font-medium text-slate-500 bg-transparent hover:bg-white focus:bg-white border border-transparent hover:border-slate-200 focus:border-emerald-600 rounded-lg px-2 py-0.5 focus:outline-none transition-all truncate font-mono"
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submenu Controls -->
                                    <div class="flex items-center gap-1.5 shrink-0 self-end sm:self-center">
                                        <!-- Urutan -->
                                        <input 
                                            type="number" 
                                            value="{{ $sub->urutan }}" 
                                            wire:change="updateInline('{{ $sub->id }}', 'urutan', $event.target.value)"
                                            class="w-8 text-[11px] font-bold text-center bg-white border border-slate-200 rounded-md py-0.5"
                                            title="Nomor urutan sub-menu"
                                        >

                                        <!-- Up / Down -->
                                        <button 
                                            type="button" 
                                            wire:click="pindahUrutan('{{ $sub->id }}', 'atas')" 
                                            class="p-1 text-slate-400 hover:text-emerald-700 cursor-pointer"
                                            title="Ke Atas"
                                        >
                                            <i data-lucide="arrow-up" class="w-3 h-3"></i>
                                        </button>
                                        <button 
                                            type="button" 
                                            wire:click="pindahUrutan('{{ $sub->id }}', 'bawah')" 
                                            class="p-1 text-slate-400 hover:text-emerald-700 cursor-pointer"
                                            title="Ke Bawah"
                                        >
                                            <i data-lucide="arrow-down" class="w-3 h-3"></i>
                                        </button>

                                        <!-- Status Toggle -->
                                        <button 
                                            type="button" 
                                            wire:click="toggleAktif('{{ $sub->id }}')" 
                                            class="p-1 px-2 rounded-lg text-[10px] font-bold cursor-pointer {{ $sub->status_aktif ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}"
                                        >
                                            {{ $sub->status_aktif ? 'Aktif' : 'Mati' }}
                                        </button>

                                        <!-- Clone -->
                                        <button 
                                            type="button" 
                                            wire:click="duplikatMenu('{{ $sub->id }}')" 
                                            class="p-1 text-slate-400 hover:text-blue-700 cursor-pointer"
                                            title="Duplikat Sub-menu"
                                        >
                                            <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                        </button>

                                        <!-- Edit -->
                                        <button 
                                            type="button" 
                                            wire:click="bukaModalEdit('{{ $sub->id }}')" 
                                            class="p-1 text-slate-400 hover:text-amber-700 cursor-pointer"
                                            title="Edit Sub-menu"
                                        >
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                        </button>

                                        <!-- Delete -->
                                        <button 
                                            type="button" 
                                            wire:click="hapus('{{ $sub->id }}')" 
                                            wire:confirm="Yakin ingin menghapus sub-menu '{{ $sub->nama }}'?"
                                            class="p-1 text-slate-400 hover:text-rose-600 cursor-pointer"
                                            title="Hapus Sub-menu"
                                        >
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            @empty
                <div class="p-12 text-center bg-slate-50/70 rounded-3xl border border-dashed border-slate-200">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="folder-plus" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800">Belum ada data menu untuk grup ini</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        Klik tombol "Tambah Menu Baru" atau "Pulihkan Default" untuk menambahkan item navigasi.
                    </p>
                    <div class="mt-4 flex items-center justify-center gap-2">
                        <button 
                            type="button" 
                            wire:click="bukaModalTambah" 
                            class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-colors cursor-pointer"
                        >
                            Tambah Menu
                        </button>
                        <button 
                            type="button" 
                            wire:click="resetKeDefault" 
                            class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-800 text-xs font-bold transition-colors cursor-pointer"
                        >
                            Muat Default
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

    </div>

    <!-- ========================================================================= -->
    <!-- MODAL FORM CREATE / EDIT MENU                                             -->
    <!-- ========================================================================= -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-in fade-in duration-200">
            
            <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-slate-100 p-6 sm:p-8 space-y-6 relative" @click.away="$wire.tutupModal()">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div>
                        <span class="text-[10px] font-black tracking-wider uppercase text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">
                            {{ $editId ? 'Ubah Menu' : 'Tambah Menu Baru' }}
                        </span>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight mt-1.5">
                            {{ $editId ? 'Edit Pengaturan Menu' : 'Formulir Menu Navigasi' }}
                        </h3>
                    </div>
                    <button 
                        type="button" 
                        wire:click="tutupModal" 
                        class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors cursor-pointer"
                    >
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- Form -->
                <form wire:submit="simpan" class="space-y-4">
                    
                    <!-- Lokasi Grup & Induk Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Grup -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">
                                Lokasi / Grup Menu <span class="text-rose-500">*</span>
                            </label>
                            <select 
                                wire:model.live="grup" 
                                class="w-full h-11 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:bg-white focus:border-emerald-600 focus:outline-none"
                            >
                                <option value="frontend_header">Frontend Navbar (Header)</option>
                                <option value="frontend_footer">Frontend Footer</option>
                                <option value="backend_sidebar">Backend Sidebar CMS</option>
                            </select>
                            @error('grup') <span class="text-[11px] font-bold text-rose-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- Menu Induk (Parent) -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">
                                Menu Induk (Hierarki)
                            </label>
                            <select 
                                wire:model="induk_id" 
                                class="w-full h-11 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:bg-white focus:border-emerald-600 focus:outline-none"
                            >
                                <option value="">-- Menu Utama (Tanpa Induk) --</option>
                                @foreach($parentOptions as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->nama }}</option>
                                @endforeach
                            </select>
                            @error('induk_id') <span class="text-[11px] font-bold text-rose-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Nama Label & Icon Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                        <!-- Nama Label -->
                        <div class="sm:col-span-7 space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">
                                Nama / Label Menu <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                wire:model="nama" 
                                placeholder="Contoh: Berita & Artikel" 
                                required
                                class="w-full h-11 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm font-bold text-slate-800 focus:bg-white focus:border-emerald-600 focus:outline-none"
                            >
                            @error('nama') <span class="text-[11px] font-bold text-rose-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- Icon Lucide -->
                        <div class="sm:col-span-5 space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">
                                Icon Lucide
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-emerald-600">
                                    @if($icon)
                                        <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
                                    @else
                                        <i data-lucide="sparkles" class="w-4 h-4 text-slate-400"></i>
                                    @endif
                                </div>
                                <input 
                                    type="text" 
                                    wire:model.live.debounce.200ms="icon" 
                                    placeholder="contoh: home, trophy" 
                                    class="w-full h-11 pl-9 pr-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:bg-white focus:border-emerald-600 focus:outline-none"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Quick Icon Picker Chips -->
                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1.5">Pilihan Icon Populer:</span>
                        <div class="flex flex-wrap gap-1.5 max-h-24 overflow-y-auto">
                            @foreach($popularIcons as $pIcon)
                                <button 
                                    type="button" 
                                    wire:click="$set('icon', '{{ $pIcon }}')"
                                    class="p-1.5 px-2 rounded-lg text-xs flex items-center gap-1 font-medium transition-colors cursor-pointer {{ $icon === $pIcon ? 'bg-emerald-600 text-white' : 'bg-white hover:bg-emerald-50 text-slate-700 border border-slate-200' }}"
                                >
                                    <i data-lucide="{{ $pIcon }}" class="w-3.5 h-3.5"></i>
                                    <span class="text-[10px]">{{ $pIcon }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tautan / URL & Target Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                        <!-- Tautan -->
                        <div class="sm:col-span-8 space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">
                                Tautan / URL / Route Name <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                wire:model="tautan" 
                                placeholder="Contoh: /berita, admin.berita, atau https://..." 
                                required
                                class="w-full h-11 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-800 focus:bg-white focus:border-emerald-600 focus:outline-none"
                            >
                            @error('tautan') <span class="text-[11px] font-bold text-rose-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- Target -->
                        <div class="sm:col-span-4 space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">
                                Target Jendela
                            </label>
                            <select 
                                wire:model="target" 
                                class="w-full h-11 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:bg-white focus:border-emerald-600 focus:outline-none"
                            >
                                <option value="_self">_self (Halaman Sama)</option>
                                <option value="_blank">_blank (Tab Baru)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Urutan, Badge & Status Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Urutan -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">
                                Nomor Urutan <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                wire:model="urutan" 
                                min="0" 
                                required
                                class="w-full h-11 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:bg-white focus:border-emerald-600 focus:outline-none"
                            >
                        </div>

                        <!-- Badge -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">
                                Teks Badge (Opsional)
                            </label>
                            <input 
                                type="text" 
                                wire:model="badge" 
                                placeholder="Contoh: Bedas, Baru" 
                                class="w-full h-11 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:bg-white focus:border-emerald-600 focus:outline-none"
                            >
                        </div>

                        <!-- Status Aktif Toggle -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">
                                Status Visibilitas
                            </label>
                            <div class="h-11 flex items-center">
                                <label class="flex items-center gap-2 cursor-pointer select-none">
                                    <input 
                                        type="checkbox" 
                                        wire:model="status_aktif" 
                                        class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 transition-colors cursor-pointer"
                                    >
                                    <span class="text-xs font-bold text-slate-700">
                                        {{ $status_aktif ? 'Tampilkan Menu (Aktif)' : 'Sembunyikan Menu' }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Hak Akses (Khusus Sidebar Backend) -->
                    @if($grup === 'backend_sidebar')
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">
                                Hak Akses Peran Khusus (Opsional)
                            </label>
                            <select 
                                wire:model="hak_akses" 
                                class="w-full h-11 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:bg-white focus:border-emerald-600 focus:outline-none"
                            >
                                <option value="">-- Terbuka Untuk Semua Pengguna CMS --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->slug }}">{{ $role->nama_peran }} ({{ $role->slug }})</option>
                                @endforeach
                            </select>
                            <p class="text-[11px] text-slate-400">Kosongkan jika menu dapat dilihat oleh semua peran admin.</p>
                        </div>
                    @endif

                    <!-- Modal Actions -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                        <button 
                            type="button" 
                            wire:click="tutupModal" 
                            class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer"
                        >
                            Batal
                        </button>

                        <button 
                            type="submit" 
                            wire:loading.attr="disabled"
                            class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 via-emerald-600 to-teal-700 hover:from-emerald-500 hover:to-teal-600 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-emerald-600/20 active:scale-95 transition-all flex items-center gap-2 cursor-pointer"
                        >
                            <span wire:loading.remove wire:target="simpan">{{ $editId ? 'Simpan Perubahan' : 'Tambah Menu' }}</span>
                            <span wire:loading.flex wire:target="simpan" class="items-center gap-2">
                                <svg class="animate-spin-custom w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-85" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Menyimpan...</span>
                            </span>
                        </button>
                    </div>

                </form>

            </div>

        </div>
    @endif

</div>
