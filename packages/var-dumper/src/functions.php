<?php declare(strict_types=1);

namespace {
    use Tale\VarDumper;

    if (!function_exists('dump')) {
        function dump(mixed ...$values)
        {
            VarDumper::dump(...$values);
        }
    }

    if (!function_exists('tale_dump')) {
        function tale_dump(mixed ...$values)
        {
            VarDumper::dump(...$values);
        }
    }
}

namespace Tale {
    function dump(mixed ...$values)
    {
        VarDumper::dump(...$values);
    }
}
