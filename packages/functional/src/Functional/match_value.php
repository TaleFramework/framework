<?php declare(strict_types=1);

namespace Tale\Functional;

function match_value(iterable $conditionSet): callable
{
    return static function ($value) use ($conditionSet) {
        foreach ($conditionSet as [$condition, $modifier]) {
            if ($condition($value)) {
                return $modifier($value);
            }
        }
        return null;
    };
}
