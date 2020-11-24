<?php declare(strict_types=1);

namespace Tale\Serializer;

use Psr\Http\Message\StreamInterface;
use Tale\SerializerInterface;
use Tale\TypeInfo\GuesserInterface;
use Tale\TypeInfo\ParserInterface;
use Tale\TypeInfoInterface;

final class StandardSerializer implements SerializerInterface
{
    /**
     * @param iterable<EncoderInterface> $encoders
     * @param iterable<NormalizerInterface> $normalizers
     * @param iterable<FactoryInterface> $factories
     * @param ParserInterface $parser
     * @param GuesserInterface $guesser
     */
    public function __construct(
        private iterable $encoders,
        private iterable $normalizers,
        private iterable $factories,
        private ParserInterface $parser,
        private GuesserInterface $guesser
    ) {}

    public function serialize(StreamInterface $stream, mixed $value, string $format = 'json'): void
    {
        $encoder = $this->getEncoderForFormat($format);
        $normalized = $this->normalize($value, $format);
        $encoder->encode($stream, $normalized);
    }

    public function deserialize(StreamInterface $stream, string|TypeInfoInterface $type, string $format = 'json'): mixed
    {
        $encoder = $this->getEncoderForFormat($format);
        $data = $encoder->decode($stream);
        return $this->denormalize($data, $type, $format);
    }

    public function normalize(mixed $value, string $format = 'json'): mixed
    {
        $typeInfo = $this->guesser->guessType($value);
        $context = new Context($format, $this->normalizers, $this->factories, $this->parser);
        return $context->normalize($value, $typeInfo);
    }

    public function denormalize(mixed $data, string|TypeInfoInterface $type, string $format = 'json'): mixed
    {
        $typeInfo = $type instanceof TypeInfoInterface ? $type : $this->parser->parse($type);
        $context = new Context($format, $this->normalizers, $this->factories, $this->parser);
        return $context->denormalize($data, $typeInfo);
    }

    private function getEncoderForFormat(string $format): EncoderInterface
    {
        foreach ($this->encoders as $encoder) {
            if ($encoder->supports($format)) {
                return $encoder;
            }
        }
        throw new \RuntimeException('Failed to find an encoder for format ' . $format);
    }
}
