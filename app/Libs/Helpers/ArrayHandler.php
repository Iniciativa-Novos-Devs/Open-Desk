<?php

namespace App\Libs\Helpers;

class ArrayHandler
{
    /**
     * function invertPositionWith
     *
     * @param array $originalArray, int $currentPosition, int $desiredPosition
     * @return array
     */
    public static function invertPositionWith(
        array $originalArray,
        int $currentPosition,
        int $desiredPosition
    ): array {
        $originalArrayValidKeys = \array_filter(
            array_keys($originalArray),
            'is_numeric'
        );

        $originalArray = \array_filter(
            $originalArray,
            fn ($key) => \in_array($key, $originalArrayValidKeys),
            ARRAY_FILTER_USE_KEY
        );

        $target = $currentPosition; // target aqui

        $keys = array_keys($originalArray);

        $targetPosition = array_search($target, $keys);

        $beforeTarget = $keys[$targetPosition + ($desiredPosition)] ?? null; // Posicao do item anterior ao alvo

        if (!$beforeTarget) {
            return $originalArray ?? [];
        }

        $temporaryPositionForBeforeTarget = $beforeTarget + 1; // Posicao temporária do item anterior ao alvo

        // Copy current value of BEFORE target item to new position
        $originalArray[$temporaryPositionForBeforeTarget] = $originalArray[$beforeTarget];

        // Remove BEFORE target item
        unset($originalArray[$beforeTarget]);

        // Copy current value of target to new position
        $originalArray[$beforeTarget] = $originalArray[$target]; // Nova posicao do alvo

        unset($originalArray[$target]);

        $originalArray[$target] = $originalArray[$temporaryPositionForBeforeTarget]; // Posicao final do item anterior ao alvo

        unset($originalArray[$temporaryPositionForBeforeTarget]); // Remove a posicao temporária do item anterior ao alvo

        return $originalArray ?? [];
    }
}
