<?php declare(strict_types=1);

namespace Tale\Serializer;

use Tale\Serializer\Exception\FactoryException;
use Tale\TypeInfo\ParserInterface;
use Tale\TypeInfoInterface;

final class Context
{
    /**
     * Context constructor.
     * @param string $format
     * @param iterable<NormalizerInterface> $normalizers
     * @param iterable<FactoryInterface> $factories
     * @param ParserInterface $parser
     */
    public function __construct(
        private string $format,
        private iterable $normalizers,
        private iterable $factories,
        private ParserInterface $parser,
    ) {}

    public function normalize(mixed $value, TypeInfoInterface $typeInfo): mixed
    {
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supports($this->format, $typeInfo)) {
                return $normalizer->normalize($this, $value, $typeInfo);
            }
        }
        return $value;
    }

    public function denormalize(mixed $data, TypeInfoInterface $typeInfo): mixed
    {
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supports($this->format, $typeInfo)) {
                return $normalizer->denormalize($this, $data, $typeInfo);
            }
        }
        return $data;
    }

    public function createInstance(TypeInfoInterface $typeInfo, array $parameters = []): mixed
    {
        foreach ($this->factories as $factory) {
            if ($factory->supports($typeInfo)) {
                return $factory->createInstance($typeInfo, $parameters);
            }
        }
        throw new FactoryException('Failed to create instance: No supporting factory found');
    }
}
