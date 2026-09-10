<?php

namespace App\Livewire\Admin\Organisasi;

use App\Models\VisiMisiModel;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Visi & Misi - KORMI CMS')]
class VisiMisiKelola extends Component
{
    use WithPagination;

    public string $mode = 'tabel';
    public string $filterJenis = 'semua';

    // Form fields
    public ?string $editId = null;
    public string $jenis = 'misi';
    public string $konten = '';
    public string $ikon = '';
    public int $urutan = 0;
    public bool $status_tampil = true;

    protected function rules(): array
    {
        return [
            'jenis' => 'required|in:visi,misi,nilai_utama,motto,tujuan',
            'konten' => 'required|string|min:5',
            'ikon' => 'nullable|string|max:50',
            'urutan' => 'integer|min:0',
            'status_tampil' => 'boolean',
        ];
    }

    public function kembaliKeTabel(): void
    {
        $this->mode = 'tabel';
        $this->resetInput();
    }

    public function bukaFormTambah(): void
    {
        $this->resetInput();
        $this->mode = 'form';
        $this->resetErrorBag();
    }

    public function bukaFormEdit(string $id): void
    {
        $item = VisiMisiModel::findOrFail($id);
        $this->editId = $item->id;
        $this->jenis = $item->jenis;
        $this->konten = $item->konten;
        $this->ikon = $item->ikon ?? '';
        $this->urutan = $item->urutan;
        $this->status_tampil = $item->status_tampil;
        $this->mode = 'form';
        $this->resetErrorBag();
    }

    public function simpan(): void
    {
        $this->validate();

        $data = [
            'jenis' => $this->jenis,
            'konten' => trim($this->konten),
            'ikon' => $this->ikon ?: null,
            'urutan' => $this->urutan,
            'status_tampil' => $this->status_tampil,
        ];

        if ($this->editId) {
            VisiMisiModel::findOrFail($this->editId)->update($data);
            session()->flash('pesan', 'Data visi/misi berhasil diperbarui!');
        } else {
            $data['id'] = (string) Str::uuid();
            VisiMisiModel::create($data);
            session()->flash('pesan', 'Data visi/misi baru berhasil ditambahkan!');
        }

        $this->kembaliKeTabel();
    }

    public function hapus(string $id): void
    {
        VisiMisiModel::findOrFail($id)->delete();
        session()->flash('pesan', 'Data visi/misi berhasil dihapus.');
    }

    public function resetInput(): void
    {
        $this->editId = null;
        $this->jenis = 'misi';
        $this->konten = '';
        $this->ikon = '';
        $this->urutan = 0;
        $this->status_tampil = true;
    }

    public function render()
    {
        $jenisOptions = ['visi', 'misi', 'nilai_utama', 'motto', 'tujuan'];
        $jenisLabels = [
            'visi' => 'Visi',
            'misi' => 'Misi',
            'nilai_utama' => 'Nilai Utama',
            'motto' => 'Motto',
            'tujuan' => 'Tujuan',
        ];

        $query = VisiMisiModel::query()
            ->when($this->filterJenis !== 'semua', fn($q) => $q->where('jenis', $this->filterJenis))
            ->orderBy('jenis')
            ->orderBy('urutan');

        $counts = [];
        foreach ($jenisOptions as $j) {
            $counts[$j] = VisiMisiModel::where('jenis', $j)->count();
        }

        return view('livewire.admin.organisasi.visimisi-kelola', [
            'visiMisiList' => $query->paginate(15),
            'jenisOptions' => $jenisOptions,
            'jenisLabels' => $jenisLabels,
            'counts' => $counts,
            'totalVisiMisi' => VisiMisiModel::count(),
        ]);
    }
}
