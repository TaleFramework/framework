<?php declare(strict_types=1);

namespace Tale;

use Tale\Stream\ResourceStream;
use Tale\VarDumper\AnsiVarDumper;

final class VarDumper
{
    private function __construct() {}

    public static function dump(mixed ...$values) {
        $isCli = str_starts_with(php_sapi_name(), 'cli');
        $stream = $isCli
            ? ResourceStream::createStdoutStream()
            : ResourceStream::createOutputStream();
        $dumper = $isCli
            ? new AnsiVarDumper()
            : new AnsiVarDumper(); // TODO: Add HtmlDumper here
        foreach ($values as $value) {
            $dumper->dump($stream, $value);
        }
    }
}
