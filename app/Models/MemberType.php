<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MemberType extends Model
{
    protected $fillable = ['name', 'description', 'max_limit'];

    protected static function booted(): void
    {
        static::deleting(function (MemberType $memberType) {
            if ($memberType->members()->exists()) {
                throw new \Exception('Não é possível excluir: existem membros associados a este tipo de membro.');
            }
        });
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function fees(): HasMany
    {
        return $this->hasMany(MemberFee::class);
    }

    public function getCurrentFee(): ?MemberFee
    {
        return $this->fees()
            ->where('valid_until', '>=', now())
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
