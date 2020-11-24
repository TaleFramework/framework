<?php declare(strict_types=1);

include __DIR__ . '/../vendor/autoload.php';

include __DIR__ . '/SomeClass.php';

$serializer = new \Tale\Serializer\StandardSerializer(
    [new \Tale\Serializer\Json\Encoder\PhpExtensionEncoder()],
    [new \Tale\Serializer\Json\Normalizer\IterableNormalizer()],
    [new \Tale\Serializer\Factory\StandardFactory()],
    new \Tale\TypeInfo\Parser\StandardParser(),
    new \Tale\TypeInfo\Guesser\StandardGuesser(),
);

$serializer->serialize(\Tale\Stream\ResourceStream::createStdoutStream(), new ArrayObject([
    1, 2, 3,
]));


tale_dump(
    $serializer->deserialize(\Tale\Stream\ResourceStream::createMemoryStream('[1,2,3]'), ArrayObject::class)
);
