<?php

namespace App\Services;

use App\Models\ChoreographyType;

class DancerValidationService
{
    /**
     * Valida se a quantidade de bailarinos selecionados
     * está dentro dos limites definidos pelo ChoreographyType.
     *
     * @param  int        $choreographyTypeId
     * @param  array      $dancerIds           IDs dos bailarinos selecionados
     * @return array{valid: bool, message: string}
     */
    public function validateDancerCount(int $choreographyTypeId, array $dancerIds): array
    {
        $type = ChoreographyType::find($choreographyTypeId);

        if (! $type) {
            return ['valid' => false, 'message' => 'Tipo de coreografia não encontrado.'];
        }

        $count = count($dancerIds);

        if ($type->min_dancers !== null && $count < $type->min_dancers) {
            return [
                'valid'   => false,
                'message' => "A formação \"{$type->name}\" exige no mínimo {$type->min_dancers} bailarino(s). Você selecionou {$count}.",
            ];
        }

        if ($type->max_dancers !== null && $count > $type->max_dancers) {
            return [
                'valid'   => false,
                'message' => "A formação \"{$type->name}\" permite no máximo {$type->max_dancers} bailarino(s). Você selecionou {$count}.",
            ];
        }

        return ['valid' => true, 'message' => ''];
    }
}