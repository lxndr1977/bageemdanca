<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanceStyle extends Model
{
    protected $fillable = ['name'];

    protected static function booted(): void
    {
        static::deleting(function (DanceStyle $danceStyle) {
            if ($danceStyle->choreographies()->exists()) {
                throw new \Exception('Não é possível excluir: esta modalidade possui coreografias associadas.');
            }
        });
    }

    public function choreographies()
    {
        return $this->hasMany(Choreography::class);
    }
}
