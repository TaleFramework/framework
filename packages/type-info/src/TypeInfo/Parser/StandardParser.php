<?php declare(strict_types=1);

namespace Tale\TypeInfo\Parser;

use Tale\TypeInfo\BuiltinTypeInfo;
use Tale\TypeInfo\ParserInterface;
use Tale\TypeInfo;
use Tale\TypeInfoInterface;
use function in_array;

/**
 * The StandardParser will parse fully-qualified type names to type information.
 *
 * Once it parsed a type by name, it will always return the same information instance (runtime caching).
 */
final class StandardParser implements ParserInterface
{
    private const NORMALIZE_PATTERNS = [
        // Turn array<string, int> to array<string,int>, string | null to string|null
        '/\s*/',
        // Turn Xyz[] to array<Xyz> and \Some\Class to Some\Class
        '/^([^\[]+)\[\]$/',
    ];

    private const NORMALIZE_REPLACEMENTS = [
        '',
        'array<$1>',
    ];

    /**
     * The runtime-cached type infos.
     *
     * @var TypeInfoInterface[]
     */
    private array $typeInfos = [];

    public function parse(string $type, array $classAliasMap = []): TypeInfoInterface
    {
        // TODO: Proper union parsing (e.g. int|string is not supported right now
        //       but will also need to support e.g. Collection<A>|Selectable<A> and Collection<A | B>
        $normalizedName = match ($type) {
            'NULL' => 'null', // Special case for gettype's return value
            default => preg_replace(self::NORMALIZE_PATTERNS, self::NORMALIZE_REPLACEMENTS, $type),
        };

        if (isset($this->typeInfos[$normalizedName])) {
            return $this->typeInfos[$normalizedName];
        }

        /** @var TypeInfoInterface|null $typeInfo */
        $typeInfo = null;
        $nullable = false;
        if (str_starts_with($normalizedName, '?')) {
            $normalizedName = substr($normalizedName, 1);
            $nullable = true;
        }
        // Check if it's a built-in type
        if (in_array($normalizedName, BuiltinTypeInfo::NAMES, true)) {
            $typeInfo = TypeInfo::createBuiltIn($normalizedName);
        }
        if (!$typeInfo) {
            // Expand class name based on class alias map (use-statements)
            foreach ($classAliasMap as $alias => $name) {
                if ($alias === $normalizedName) {
                    $normalizedName = $name;
                    break;
                }
                if (str_starts_with("{$alias}\\", $normalizedName)) {
                    $normalizedName = $name . substr($normalizedName, 0, strlen($alias));
                    break;
                }
            }
            if (str_starts_with($normalizedName, '\\')) {
                $normalizedName = substr($normalizedName, 1);
            }
            // Read generic type and parameters, if it is one
            // TODO: This is a very simple pattern, it won't read nested generics at all!
            if (preg_match('/^([^<]+)<([^>]+)>$/', $normalizedName, $matches)) {
                $genericType = $this->parse($matches[1], $classAliasMap);
                $genericParameterTypes = array_map(
                    fn(string $type) => $this->parse($type, $classAliasMap),
                    explode(',', $matches[2]),
                );
                $typeInfo = TypeInfo::createGeneric($genericType, $genericParameterTypes);
            } else {
                $typeInfo = TypeInfo::createClass($normalizedName);
            }
        }
        $typeInfo ??= TypeInfo::createMixed();
        if ($nullable) {
            $typeInfo = TypeInfo::nullable($typeInfo);
        }
        return $this->typeInfos[$type] = $typeInfo;
    }
}
