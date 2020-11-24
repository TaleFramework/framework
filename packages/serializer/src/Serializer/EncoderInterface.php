<?php declare(strict_types=1);

namespace Tale\Serializer;

use Psr\Http\Message\StreamInterface;

interface EncoderInterface
{
    public function supports(string $format): bool;
    public function encode(StreamInterface $stream, mixed $value): void;
    public function decode(StreamInterface $stream): mixed;
}
