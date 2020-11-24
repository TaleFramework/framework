<?php declare(strict_types=1);

namespace Tale\Stream;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

/**
 * A basic factory implementation to create some stream instances.
 *
 * Inject a Psr\Http\Message\StreamFactoryInterface to get this instance
 * in your DI container.
 */
final class ResourceStreamFactory implements StreamFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createStream(string $content = ''): StreamInterface
    {
        return ResourceStream::createMemoryStream($content);
    }

    /**
     * {@inheritdoc}
     */
    public function createStreamFromFile(string $filename, string $mode = 'rb'): StreamInterface
    {
        return ResourceStream::createFileStream($filename, $mode);
    }

    /**
     * {@inheritdoc}
     */
    public function createStreamFromResource($resource): StreamInterface
    {
        return new ResourceStream($resource);
    }
}
