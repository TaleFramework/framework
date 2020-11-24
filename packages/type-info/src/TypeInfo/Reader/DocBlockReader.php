<?php declare(strict_types=1);

namespace Tale\TypeInfo\Reader;

use Generator;
use ReflectionException;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionProperty;
use Tale\TypeInfo\ParameterInfo;
use Tale\TypeInfo\ParserInterface;
use Tale\TypeInfo\ReaderInterface;
use Tale\TypeInfo;
use Tale\TypeInfoInterface;

final class DocBlockReader implements ReaderInterface
{
    private const READ_TYPE_PARAM = 'param';
    private const READ_TYPE_RETURN = 'return';
    private const READ_TYPE_VAR = 'var';

    private array $fileUseStatements = [];

    public function __construct(
        private ParserInterface $parser
    ) {}

    /**
     * Reads parameter types from a method.
     *
     * Example:
     * ```
     * class SomeClass
     * {
     *     /**
     *      *
     * @param ReflectionMethod|ReflectionFunction $function
     * @return iterable<ParameterInfo>
     */
    public function readParameters(ReflectionMethod|ReflectionFunction $function): iterable
    {
        foreach ($this->parseDocCommentParams(self::READ_TYPE_PARAM, $function) as $name => $typeInfo) {
            yield $name => new ParameterInfo($name, $typeInfo, false, null);
        }
    }

    /**
     * @param ReflectionMethod|ReflectionFunction $function
     * @return TypeInfo
     */
    public function readReturnValue(ReflectionMethod|ReflectionFunction $function): TypeInfoInterface
    {
        foreach ($this->parseDocCommentParams(self::READ_TYPE_RETURN, $function) as $name => $typeInfo) {
            return $typeInfo;
        }
    }

    /**
     * @param ReflectionProperty $property
     * @return TypeInfo
     */
    public function readProperty(ReflectionProperty $property): TypeInfoInterface
    {
        foreach ($this->parseDocCommentParams(self::READ_TYPE_VAR, $property) as $name => $typeInfo) {
            return $typeInfo;
        }
    }

    /**
     * Reads the doc-comment of a method and parses it into an iterable of TypeInformation keyed by parameter name.
     *
     * @param string $type
     * @param ReflectionMethod|ReflectionFunction|ReflectionProperty $reflection The reflection method to parse the docblock of.
     * @return Generator<int, TypeInfo, void, void> An iterable of TypeInfo keyed by the parameter name.
     */
    private function parseDocCommentParams(
        string $type,
        ReflectionMethod|ReflectionFunction|ReflectionProperty $reflection,
    ): Generator {
        $docBlock = $reflection->getDocComment();
        $useStatements = $this->getUseStatements($reflection);
        if (!is_string($docBlock)) {
            return;
        }
        if (!preg_match_all(sprintf('/@%s\s+([^$]+)\s+\$(\w+)/', $type), $docBlock, $matches)) {
            return;
        }
        $len = count($matches[0]);
        for ($i = 0; $i < $len; $i++) {
            $types = $matches[1][$i];
            $name = $matches[2][$i];
            // TODO: This doesn't support Collection<A | B> correctly
            $types = array_map(
                fn (string $type) => $this->parser->parse($type, $useStatements),
                array_values(array_filter(array_map('trim', explode('|', $types)))),
            );

            yield $name => TypeInfo::createUnion($types);
        }
    }

    private function getUseStatements(ReflectionMethod|ReflectionFunction|ReflectionProperty $reflection): array
    {
        $filePath = $reflection->getFileName();
        return $this->fileUseStatements[$filePath] ??
            ($this->fileUseStatements[$filePath] = iterator_to_array($this->readUseStatements($filePath)));
    }

    private function readUseStatements(string $filePath): Generator
    {
        $tokens = token_get_all(file_get_contents($filePath));
        $inUseStatement = false;
        $currentName = null;
        $inAlias = false;
        $currentAlias = null;
        foreach ($tokens as $token) {
            [$id, $value, $line] = $token;
            if ($id !== T_USE && !$inUseStatement) {
                continue;
            }
            if (in_array($id, [T_CLASS, T_FUNCTION, T_CONST, T_INTERFACE, T_TRAIT], true)) {
                // No need to search further, use-statements should all be at the start of the file
                break;
            }
            if (!$inUseStatement && $id === T_USE) {
                $inUseStatement = true;
                continue;
            }
            if ($inUseStatement && $id === T_NAME_QUALIFIED) {
                $currentName = $value;
                continue;
            }

            if (!$inAlias && $id === T_AS) {
                $inAlias = true;
                continue;
            }

            if ($inAlias && $id === T_STRING) {
                $currentAlias = $value;
                $inAlias = false;
                continue;
            }

            if ($inUseStatement && $token === ';') {
                $nameParts = explode('\\', $currentName);
                yield $currentAlias ?? end($nameParts) => $currentName;
                $currentName = null;
                $currentAlias = null;
                $inUseStatement = false;
                continue;
            }
        }
    }
}
