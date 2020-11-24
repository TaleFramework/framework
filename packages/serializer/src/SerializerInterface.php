<?php

namespace Tale;

use Psr\Http\Message\StreamInterface;

interface SerializerInterface
{
    public function serialize(StreamInterface $stream, mixed $value, string $format = 'json'): void;
    public function deserialize(
        StreamInterface $stream,
        string|TypeInfoInterface $type,
        string $format = 'json'
    ): mixed;

    public function normalize(mixed $value, string $format = 'json'): mixed;
    public function denormalize(mixed $data, string|TypeInfoInterface $type, string $format = 'json'): mixed;
}
