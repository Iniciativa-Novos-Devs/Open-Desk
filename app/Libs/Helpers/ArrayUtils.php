<?php

namespace App\Libs\Helpers;

class ArrayUtils
{
    /**
     * function implodeAssoc
     *
     * @param array $array
     * @return string
     */
    public static function implodeAssoc(
        array $array,
        string $itemsGlue = ' ',
        string $template = '##_KEY_##="##_VALUE_##"',
        string $endOfString = ''
    ): string {
        if (!static::isAssoc($array)) {
            return '';
        }

        foreach ($array as $key => $value) {
            $result[] = \str_replace(
                [
                    '##_KEY_##',
                    '##_VALUE_##'
                ],
                [
                    $key,
                    $value,
                ],
                $template
            );
        }

        if (!count($result ?? [])) {
            return '';
        }

        return \implode(
            $itemsGlue,
            $result
        ) . $endOfString;
    }

    /**
     * isAssoc function
     *
     * @param array $array
     * @return boolean
     */
    public static function isAssoc(array $array)
    {
        if ([] === $array) {
            return false;
        }

        return count(
            \array_filter(
                array_keys($array),
                'is_numeric'
            )
        ) === 0;
    }

    /**
     * isList function
     *
     * @param array $array
     * @return boolean
     */
    public static function isList(array $array)
    {
        if ([] === $array) {
            return false;
        }

        $arrayKeys = array_keys($array);

        return count(
            \array_filter(
                $arrayKeys,
                'is_numeric'
            )
        ) === count(
            $arrayKeys
        );
    }

    /**
     * flatten function
     *
     * @param array $multiDimArray
     * @return array
     */
    public static function flatten(array $multiDimArray): array
    {
        $localFlatten = [];

        foreach ($multiDimArray as $key => $value) {
            if (\is_array($value)) {
                foreach (static::flatten($value) as $subKey => $subValue) {
                    $localFlatten[$subKey] = $subValue;
                }

                continue;
            }

            $localFlatten[$key] = $value;
        }

        return $localFlatten;
    }
}
