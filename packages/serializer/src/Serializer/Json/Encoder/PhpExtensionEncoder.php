<?php declare(strict_types=1);

namespace Tale\Serializer\Json\Encoder;

use JsonException;
use Psr\Http\Message\StreamInterface;
use Tale\Serializer\EncoderInterface;

final class PhpExtensionEncoder implements EncoderInterface
{
    public function supports(string $format): bool
    {
        return $format === 'json';
    }

    /**
     * @param StreamInterface $stream
     * @param mixed $value
     * @return void
     * @throws JsonException
     */
    public function encode(StreamInterface $stream, mixed $value): void
    {
        $stream->write(json_encode($value, JSON_THROW_ON_ERROR));
    }

    /**
     * @param StreamInterface $stream
     * @return mixed
     * @throws JsonException
     */
    public function decode(StreamInterface $stream): mixed
    {
        return json_decode($stream->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}
