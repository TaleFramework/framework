<?php declare(strict_types=1);

namespace Tale\Functional;

function set_path(array $path, $value, iterable $items): iterable
{
    $array = unwind($items);
    $current = &$array;
    foreach ($path as $key) {
        if (!array_key_exists($key, $current)) {
            $current[$key] = null;
        }
        $current = &$current[$key];
    }
    $current = $value;
    return $array;
}
