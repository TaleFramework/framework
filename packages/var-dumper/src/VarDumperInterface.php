<?php declare(strict_types=1);

namespace Tale;

use Psr\Http\Message\StreamInterface;

interface VarDumperInterface
{
    public function dump(StreamInterface $stream, mixed $value): void;
}
