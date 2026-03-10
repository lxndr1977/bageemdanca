<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChoreographyType extends Model
{
    protected $fillable = ['name', 'min_dancers', 'max_dancers'];

    protected static function booted(): void
    {
        static::deleting(function (ChoreographyType $choreographyType) {
            if ($choreographyType->choreographies()->exists()) {
                throw new \Exception('Não é possível excluir: existem coreografias associadas a este tipo de coreografia.');
            }
        });
    }

    public function choreographies(): HasMany
    {
        return $this->hasMany(Choreography::class);
    }

    public function fees(): HasMany
    {
        return $this->hasMany(ChoreographyFee::class);
    }

    public function getCurrentFee(): ?ChoreographyFee
    {
        return $this->fees()
            ->where('valid_until', '>=', now())
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
