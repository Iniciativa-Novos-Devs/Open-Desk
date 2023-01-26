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

    /**
     * function reorder
     *
     * @param array $originalArray
     * @param int $target
     * @param int $positionLogic
     * @return array
     */
    public static function reorder(
        array $originalArray,
        int $target,
        int $positionLogic
    ): array {
        if (
            $target < 0 ||
            !$originalArray ||
            $target == $positionLogic ||
            $positionLogic >= count($originalArray)
        ) {
            return $originalArray ?? [];
        }

        $sortArray = $originalArray;

        $temporaryKeyForBeforeTarget = 'temp_for_before_' . \rand(); // Chave temporária do item anterior ao alvo
        $temporaryKeyForTarget = 'temp_for_target_' . \rand();

        $keys = array_keys($sortArray);

        $targetPosition = array_search($target, $keys);

        $beforeTargetPosition = ((int) ($targetPosition ?? 0)) + $positionLogic; // Posicao do item anterior ao alvo
        $beforeTargetKey = $keys[$beforeTargetPosition] ?? null; // Item anterior ao alvo

        if (!$beforeTargetKey) {
            return $sortArray ?? [];
        }

        $beforeTargetKey = (int) ($beforeTargetKey ?? 0);

        // Copy current values of BEFORE and TARGET items to a temporary position
        $sortArray[$temporaryKeyForBeforeTarget] = $sortArray[$beforeTargetKey]; // New BEFORE temporary position
        $sortArray[$temporaryKeyForTarget] = $sortArray[$target]; // New TARGET temporary position

        // Remove BEFORE and TARGET items
        unset($sortArray[$beforeTargetKey]);
        unset($sortArray[$target]);

        // Final position for BEFORE item
        $sortArray[$beforeTargetKey + 1] = $sortArray[$temporaryKeyForBeforeTarget];

        // Remove temporary position for BEFORE item
        unset($sortArray[$temporaryKeyForBeforeTarget]);

        // Final position for TARGET item
        $sortArray[$beforeTargetKey] = $sortArray[$temporaryKeyForTarget];

        // Remove temporary position for TARGETitem
        unset($sortArray[$temporaryKeyForTarget]);

        \ksort($sortArray);

        return $sortArray ?? [];
    }
}
