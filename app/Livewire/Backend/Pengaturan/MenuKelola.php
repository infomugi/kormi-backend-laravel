<?php

namespace App\Livewire\Backend\Pengaturan;

use App\Models\Core\Menu;
use App\Models\Core\Peran;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Manajemen Menu Navigasi - KORMI CMS')]
class MenuKelola extends Component
{
    public string $grup = 'frontend_header'; // 'frontend_header', 'frontend_footer', 'backend_sidebar'
    public string $pencarian = '';
    
    // Modal Form States
    public bool $showModal = false;
    public ?string $editId = null;
    public ?string $induk_id = null;
    public string $nama = '';
    public string $tautan = '';
    public string $icon = '';
    public string $target = '_self';
    public int $urutan = 0;
    public bool $status_aktif = true;
    public string $badge = '';
    public string $hak_akses = '';
    public string $deskripsi = '';

    // Bulk selection
    public array $selectedIds = [];
    public bool $selectAll = false;

    // Fast inline edit feedback
    public ?string $inlineSuccessId = null;

    protected function rules(): array
    {
        return [
            'nama' => 'required|min:2|max:150',
            'tautan' => 'required|max:255',
            'grup' => 'required|in:frontend_header,frontend_footer,backend_sidebar',
            'induk_id' => 'nullable|exists:sys_menu,id',
            'icon' => 'nullable|max:50',
            'target' => 'required|in:_self,_blank',
            'urutan' => 'required|integer|min:0',
            'status_aktif' => 'boolean',
            'badge' => 'nullable|max:50',
            'hak_akses' => 'nullable|max:100',
            'deskripsi' => 'nullable|max:500',
        ];
    }

    protected $messages = [
        'nama.required' => 'Nama / Label menu wajib diisi.',
        'tautan.required' => 'Tautan / URL menu wajib diisi.',
        'grup.required' => 'Grup lokasi menu wajib dipilih.',
    ];

    public function setGrup(string $grup): void
    {
        $this->grup = $grup;
        $this->selectedIds = [];
        $this->selectAll = false;
        $this->pencarian = '';
        $this->resetForm();
    }

    public function updatedSelectAll(bool $value): void
    {
        if ($value) {
            $this->selectedIds = Menu::grup($this->grup)->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedIds = [];
        }
    }

    public function resetForm(): void
    {
        $this->editId = null;
        $this->induk_id = null;
        $this->nama = '';
        $this->tautan = '';
        $this->icon = '';
        $this->target = '_self';
        $this->urutan = $this->hitungUrutanBerikutnya();
        $this->status_aktif = true;
        $this->badge = '';
        $this->hak_akses = '';
        $this->deskripsi = '';
        $this->resetErrorBag();
    }

    private function hitungUrutanBerikutnya(?string $indukId = null): int
    {
        $query = Menu::grup($this->grup);
        if ($indukId) {
            $query->where('induk_id', $indukId);
        } else {
            $query->whereNull('induk_id');
        }
        $max = $query->max('urutan') ?? 0;
        return $max + 1;
    }

    public function bukaModalTambah(?string $indukId = null): void
    {
        $this->resetForm();
        $this->induk_id = $indukId;
        $this->urutan = $this->hitungUrutanBerikutnya($indukId);
        $this->showModal = true;
    }

    public function bukaModalEdit(string $id): void
    {
        $menu = Menu::findOrFail($id);
        $this->editId = $menu->id;
        $this->grup = $menu->grup;
        $this->induk_id = $menu->induk_id;
        $this->nama = $menu->nama;
        $this->tautan = $menu->tautan;
        $this->icon = $menu->icon ?? '';
        $this->target = $menu->target ?? '_self';
        $this->urutan = $menu->urutan;
        $this->status_aktif = (bool) $menu->status_aktif;
        $this->badge = $menu->badge ?? '';
        $this->hak_akses = $menu->hak_akses ?? '';
        $this->deskripsi = $menu->deskripsi ?? '';
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function tutupModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function simpan(): void
    {
        $this->validate();

        // Hindari set induk ke diri sendiri
        if ($this->editId && $this->induk_id === $this->editId) {
            $this->addError('induk_id', 'Menu tidak dapat menjadi induk bagi dirinya sendiri.');
            return;
        }

        $data = [
            'grup' => $this->grup,
            'induk_id' => $this->induk_id ?: null,
            'nama' => trim($this->nama),
            'tautan' => trim($this->tautan),
            'icon' => $this->icon ? trim($this->icon) : null,
            'target' => $this->target,
            'urutan' => $this->urutan,
            'status_aktif' => $this->status_aktif,
            'badge' => $this->badge ? trim($this->badge) : null,
            'hak_akses' => $this->hak_akses ? trim($this->hak_akses) : null,
            'deskripsi' => $this->deskripsi ? trim($this->deskripsi) : null,
        ];

        if ($this->editId) {
            $menu = Menu::findOrFail($this->editId);
            $menu->update($data);
            session()->flash('success', "Menu '{$menu->nama}' berhasil diperbarui.");
        } else {
            $data['id'] = (string) Str::uuid();
            $menu = Menu::create($data);
            session()->flash('success', "Menu baru '{$menu->nama}' berhasil ditambahkan.");
        }

        $this->tutupModal();
        $this->dispatch('menu-updated');
    }

    public function hapus(string $id): void
    {
        $menu = Menu::findOrFail($id);
        $nama = $menu->nama;
        $menu->delete();

        session()->flash('success', "Menu '{$nama}' beserta sub-menunya berhasil dihapus.");
        $this->dispatch('menu-updated');
    }

    // ==========================================
    // INLINE EDITING METHODS
    // ==========================================
    public function updateInline(string $id, string $field, mixed $value): void
    {
        $allowedFields = ['nama', 'tautan', 'icon', 'target', 'badge', 'urutan'];
        if (!in_array($field, $allowedFields)) {
            return;
        }

        $menu = Menu::find($id);
        if (!$menu) return;

        if ($field === 'nama' && empty(trim((string)$value))) {
            return;
        }

        if ($field === 'urutan') {
            $value = (int) $value;
        }

        $menu->update([
            $field => is_string($value) ? trim($value) : $value
        ]);

        $this->inlineSuccessId = $id;
        $this->dispatch('menu-inline-updated', id: $id, field: $field);
    }

    public function toggleAktif(string $id): void
    {
        $menu = Menu::findOrFail($id);
        $menu->status_aktif = !$menu->status_aktif;
        $menu->save();

        $statusText = $menu->status_aktif ? 'diaktifkan' : 'dinonaktifkan';
        session()->flash('info', "Status menu '{$menu->nama}' telah {$statusText}.");
        $this->dispatch('menu-updated');
    }

    // ==========================================
    // CLONE / DUPLICATE FEATURE
    // ==========================================
    public function duplikatMenu(string $id): void
    {
        $source = Menu::with('anak')->findOrFail($id);

        $newUrutan = $source->urutan + 1;
        // Shift existing menus after this position
        Menu::where('grup', $source->grup)
            ->where('induk_id', $source->induk_id)
            ->where('urutan', '>=', $newUrutan)
            ->increment('urutan');

        $clonedParent = Menu::create([
            'id' => (string) Str::uuid(),
            'grup' => $source->grup,
            'induk_id' => $source->induk_id,
            'nama' => $source->nama . ' (Salinan)',
            'tautan' => $source->tautan,
            'icon' => $source->icon,
            'target' => $source->target,
            'urutan' => $newUrutan,
            'status_aktif' => $source->status_aktif,
            'badge' => $source->badge,
            'hak_akses' => $source->hak_akses,
            'deskripsi' => $source->deskripsi,
        ]);

        // Duplicate child submenus if any
        if ($source->anak && $source->anak->isNotEmpty()) {
            foreach ($source->anak as $sub) {
                Menu::create([
                    'id' => (string) Str::uuid(),
                    'grup' => $sub->grup,
                    'induk_id' => $clonedParent->id,
                    'nama' => $sub->nama,
                    'tautan' => $sub->tautan,
                    'icon' => $sub->icon,
                    'target' => $sub->target,
                    'urutan' => $sub->urutan,
                    'status_aktif' => $sub->status_aktif,
                    'badge' => $sub->badge,
                    'hak_akses' => $sub->hak_akses,
                    'deskripsi' => $sub->deskripsi,
                ]);
            }
        }

        session()->flash('success', "Menu '{$source->nama}' berhasil diduplikasi.");
        $this->dispatch('menu-updated');
    }

    // ==========================================
    // DRAG & DROP REORDERING
    // ==========================================
    public function updateUrutan(array $orderedIds): void
    {
        foreach ($orderedIds as $index => $id) {
            Menu::where('id', $id)->update(['urutan' => $index + 1]);
        }

        $this->dispatch('menu-reordered');
    }

    public function pindahUrutan(string $id, string $arah): void
    {
        $menu = Menu::findOrFail($id);
        $currentUrutan = $menu->urutan;

        $targetMenu = Menu::where('grup', $menu->grup)
            ->where('induk_id', $menu->induk_id)
            ->when($arah === 'atas', function ($q) use ($currentUrutan) {
                return $q->where('urutan', '<', $currentUrutan)->orderBy('urutan', 'desc');
            }, function ($q) use ($currentUrutan) {
                return $q->where('urutan', '>', $currentUrutan)->orderBy('urutan', 'asc');
            })->first();

        if ($targetMenu) {
            $targetUrutan = $targetMenu->urutan;
            $targetMenu->update(['urutan' => $currentUrutan]);
            $menu->update(['urutan' => $targetUrutan]);
            
            $this->dispatch('menu-updated');
        }
    }

    // ==========================================
    // BULK ACTIONS
    // ==========================================
    public function bulkHapus(): void
    {
        if (empty($this->selectedIds)) return;

        $count = count($this->selectedIds);
        Menu::whereIn('id', $this->selectedIds)->delete();

        $this->selectedIds = [];
        $this->selectAll = false;
        session()->flash('success', "Sebanyak {$count} menu berhasil dihapus.");
        $this->dispatch('menu-updated');
    }

    public function bulkToggleStatus(bool $status): void
    {
        if (empty($this->selectedIds)) return;

        Menu::whereIn('id', $this->selectedIds)->update(['status_aktif' => $status]);
        $statusText = $status ? 'diaktifkan' : 'dinonaktifkan';
        session()->flash('success', count($this->selectedIds) . " menu berhasil {$statusText}.");
        $this->selectedIds = [];
        $this->selectAll = false;
        $this->dispatch('menu-updated');
    }

    public function resetKeDefault(): void
    {
        Menu::sinkronkanDefault($this->grup);
        session()->flash('success', "Struktur menu default untuk grup '" . $this->getGrupLabel() . "' berhasil dipulihkan.");
        $this->dispatch('menu-updated');
    }

    public function getGrupLabel(): string
    {
        return match ($this->grup) {
            'frontend_header' => 'Frontend Navbar (Header)',
            'frontend_footer' => 'Frontend Footer',
            'backend_sidebar' => 'Backend Sidebar CMS',
            default => 'Menu Navigasi'
        };
    }

    public function render()
    {
        // Pastikan default data ada jika kosong
        if (Menu::where('grup', $this->grup)->count() === 0) {
            Menu::sinkronkanDefault($this->grup);
        }

        $query = Menu::grup($this->grup);

        if ($this->pencarian) {
            $term = '%' . strtolower(trim($this->pencarian)) . '%';
            $query->where(function ($q) use ($term) {
                $q->whereRaw('LOWER(nama) LIKE ?', [$term])
                  ->orWhereRaw('LOWER(tautan) LIKE ?', [$term])
                  ->orWhereRaw('LOWER(badge) LIKE ?', [$term]);
            });
            $menus = $query->orderBy('urutan')->get();
        } else {
            // Get hierarchical tree
            $menus = $query->utama()
                ->with(['anak' => function ($q) {
                    $q->orderBy('urutan', 'asc')->with('anak');
                }])
                ->orderBy('urutan', 'asc')
                ->get();
        }

        // Available parent options for dropdown in modal
        $parentOptions = Menu::grup($this->grup)
            ->utama()
            ->when($this->editId, fn($q) => $q->where('id', '!=', $this->editId))
            ->orderBy('urutan')
            ->get();

        $roles = Peran::orderBy('nama_peran')->get();

        // Preset Common Icons
        $popularIcons = [
            'home', 'layout-dashboard', 'newspaper', 'file-text', 'image', 'download',
            'trophy', 'layers', 'award', 'map-pin', 'building-2', 'graduation-cap',
            'activity', 'sparkles', 'bar-chart-3', 'calendar', 'flame', 'swords',
            'external-link', 'phone', 'info', 'book-open', 'target', 'users',
            'settings', 'user-cog', 'shield', 'sliders', 'folder', 'link', 'check-circle'
        ];

        return view('livewire.backend.pengaturan.menu-kelola', [
            'menus' => $menus,
            'parentOptions' => $parentOptions,
            'roles' => $roles,
            'popularIcons' => $popularIcons,
        ]);
    }
}
