<?php

namespace App\Livewire\Publik;

use App\Models\PengaturanSitus;
use Livewire\Component;

class Kontak extends Component
{
    public string $nama = '';
    public string $email = '';
    public string $telepon = '';
    public string $subjek = '';
    public string $pesan = '';
    public bool $terkirim = false;

    protected $rules = [
        'nama' => 'required|min:3|max:100',
        'email' => 'required|email',
        'telepon' => 'nullable|max:20',
        'subjek' => 'required|min:3|max:150',
        'pesan' => 'required|min:10',
    ];

    protected $messages = [
        'nama.required' => 'Nama lengkap wajib diisi.',
        'email.required' => 'Alamat email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'subjek.required' => 'Subjek pesan wajib diisi.',
        'pesan.required' => 'Isi pesan wajib diisi.',
        'pesan.min' => 'Pesan minimal berisi :min karakter.',
    ];

    public function kirimPesan()
    {
        $this->validate();

        // Di sini bisa dikembangkan ke notifikasi email / database feedback
        $this->terkirim = true;
        $this->reset(['nama', 'email', 'telepon', 'subjek', 'pesan']);
        session()->flash('pesan_sukses', 'Terima kasih! Pesan dan aspirasi Anda telah kami terima dan akan segera ditindaklanjuti oleh Sekretariat KORMI Kabupaten Bandung.');
    }

    public function render()
    {
        $settings = PengaturanSitus::pluck('nilai_pengaturan', 'kunci_pengaturan')->toArray();

        return view('livewire.publik.kontak', [
            'alamat' => $settings['kontak_alamat'] ?? 'Komplek Stadion Si Jalak Harupat, Soreang, Kutawaringin, Kab. Bandung',
            'telepon' => $settings['kontak_telepon'] ?? '(022) 123 456 7890',
            'email' => $settings['kontak_email'] ?? 'sekretariat@kormibdg.id',
            'jamKerja' => $settings['kontak_jam_kerja'] ?? 'Senin - Jumat: 08:00 - 16:00 WIB',
            'googleMaps' => $settings['kontak_maps_iframe'] ?? 'https://maps.google.com/maps?q=Stadion%20Si%20Jalak%20Harupat&t=&z=13&ie=UTF8&iwloc=&output=embed',
        ])->layout('components.layouts.app', ['title' => 'Hubungi Kami - KORMI Kabupaten Bandung']);
    }
}
