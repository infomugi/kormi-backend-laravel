<?php

namespace App\Livewire\Frontend;

use App\Models\Core\PengaturanSitus;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Hubungi Kami & Layanan Aspirasi - KORMI Kabupaten Bandung')]
class Kontak extends Component
{
    public string $nama = '';
    public string $email = '';
    public string $telepon = '';
    public string $subjek = '';
    public string $pesan = '';
    public bool $terkirim = false;

    protected $rules = [
        'nama'    => 'required|min:3|max:100',
        'email'   => 'required|email',
        'telepon' => 'nullable|max:25',
        'subjek'  => 'required|min:3|max:150',
        'pesan'   => 'required|min:10',
    ];

    protected $messages = [
        'nama.required'   => 'Nama lengkap wajib diisi.',
        'email.required'  => 'Alamat email wajib diisi.',
        'email.email'     => 'Format email tidak valid.',
        'subjek.required' => 'Subjek keperluan wajib diisi.',
        'pesan.required'  => 'Isi pesan wajib diisi.',
        'pesan.min'       => 'Pesan minimal berisi :min karakter.',
    ];

    public function kirimPesan()
    {
        $this->validate();

        $this->terkirim = true;
        $this->reset(['nama', 'email', 'telepon', 'subjek', 'pesan']);
        session()->flash('pesan_sukses', 'Terima kasih! Pesan dan aspirasi Anda telah kami terima dan akan segera ditindaklanjuti oleh Sekretariat KORMI Kabupaten Bandung.');
    }

    public function render()
    {
        $settings = PengaturanSitus::pluck('nilai_pengaturan', 'kunci_pengaturan')->toArray();

        return view('livewire.frontend.kontak', [
            'alamat'     => $settings['alamat_kantor'] ?? $settings['kontak_alamat'] ?? 'Komplek Stadion Si Jalak Harupat, Soreang, Kutawaringin, Kab. Bandung',
            'telepon'    => $settings['nomor_telepon'] ?? $settings['kontak_telepon'] ?? '(022) 123 456 7890',
            'email'      => $settings['email_resmi'] ?? $settings['kontak_email'] ?? 'sekretariat@kormibdg.id',
            'jamKerja'   => $settings['jam_kerja'] ?? $settings['kontak_jam_kerja'] ?? 'Senin - Jumat: 08:00 - 16:00 WIB',
            'instagram'  => $settings['instagram'] ?? 'https://instagram.com/kormikabbandung',
            'youtube'    => $settings['youtube'] ?? 'https://youtube.com/@kormikabbandung',
            'facebook'   => $settings['facebook'] ?? 'https://facebook.com/kormikabupatenbandung',
            'googleMaps' => $settings['kontak_maps_iframe'] ?? 'https://maps.google.com/maps?q=Stadion%20Si%20Jalak%20Harupat&t=&z=14&ie=UTF8&iwloc=&output=embed',
        ])->layout('components.layouts.app');
    }
}

