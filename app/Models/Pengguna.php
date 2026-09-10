<?php

namespace App\Models;

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

    protected $table = 'kormi_pengguna';
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
}
