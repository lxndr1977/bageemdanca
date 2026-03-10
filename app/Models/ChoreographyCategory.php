<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChoreographyCategory extends Model
{
    protected $fillable = ['name'];

    protected static function booted(): void
    {
        static::deleting(function (ChoreographyCategory $choreographyCategory) {
            if ($choreographyCategory->choreographies()->exists()) {
                throw new \Exception('Não é possível excluir: existem coreografias associadas a esta categoria.');
            }
        });
    }

    public function choreographies()
    {
        return $this->hasMany(Choreography::class);
    }
}
