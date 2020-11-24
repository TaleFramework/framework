<?php

namespace Tale\Functional;

function comparator(callable $predicate): callable
{
    return static function ($a, $b) use ($predicate) {
        if ($predicate($a, $b)) {
            return -1;
        }
        if ($predicate($b, $a)) {
            return 1;
        }
        return 0;
    };
}
