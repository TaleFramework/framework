<?php declare(strict_types=1);

namespace Tale\TypeInfo\Reader;

use ReflectionFunction;
use ReflectionMethod;
use ReflectionProperty;
use Tale\TypeInfo;
use Tale\TypeInfo\ParserInterface;
use Tale\TypeInfo\ReaderInterface;
use Tale\TypeInfoInterface;

final class StandardReader implements ReaderInterface
{
    private ReaderInterface $internalReader;

    /**
     * @param ParserInterface $parser
     */
    public function __construct(ParserInterface $parser)
    {
        $this->internalReader = new ChainReader([
            new ReflectionReader($parser),
            new DocBlockReader($parser),
        ]);
    }

    public function readParameters(ReflectionMethod|ReflectionFunction $function): iterable
    {
        return $this->internalReader->readParameters($function);
    }

    public function readReturnValue(ReflectionMethod|ReflectionFunction $function): TypeInfoInterface
    {
        return $this->internalReader->readReturnValue($function);
    }

    public function readProperty(ReflectionProperty $property): TypeInfoInterface
    {
        return $this->internalReader->readProperty($property);
    }
}
