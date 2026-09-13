<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, HasUuids, Notifiable, SoftDeletes;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';
    const DELETED_AT = 'dihapus_pada';

    protected $table = 'sys_pengguna';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
        'terakhir_masuk' => 'datetime',
        'kata_sandi' => 'hashed',
    ];

    public function getAuthPasswordName()
    {
        return 'kata_sandi';
    }

    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    public function peran(): BelongsTo
    {
        return $this->belongsTo(Peran::class, 'peran_id');
    }

    public function isSuperAdmin(): bool
    {
        $slug = $this->peran?->slug;
        return $slug === 'super-admin' || $slug === 'superadmin' || $slug === 'admin';
    }

    public function isAdminKorcam(): bool
    {
        return $this->peran?->slug === 'admin-korcam';
    }

    public function isAdminInorga(): bool
    {
        return $this->peran?->slug === 'admin-inorga';
    }

    public function isEditorBerita(): bool
    {
        return $this->peran?->slug === 'editor-berita';
    }

    public function hasRole(string ...$roles): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        $userSlug = $this->peran?->slug;
        return in_array($userSlug, $roles, true);
    }

    public function punyaAkses(string $modulKey): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->peran ? $this->peran->punyaAkses($modulKey) : false;
    }

    public function getFotoProfilUrlAttribute(): ?string
    {
        if (empty($this->foto_profil)) {
            return null;
        }

        return app(\App\Services\StorageService::class)->getTemporaryUrl($this->foto_profil);
    }
}
