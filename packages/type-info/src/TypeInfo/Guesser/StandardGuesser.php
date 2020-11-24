<?php declare(strict_types=1);

namespace Tale\TypeInfo\Guesser;

use JetBrains\PhpStorm\Pure;
use Tale\TypeInfo;
use Tale\TypeInfo\GuesserInterface;
use Tale\TypeInfoInterface;

final class StandardGuesser implements GuesserInterface
{
    public function guessType(mixed $value): TypeInfoInterface
    {
        switch (strtolower(gettype($value))) {
            case 'null':
                return TypeInfo::createNull();
            case 'boolean':
                return TypeInfo::createBool();
            case 'string':
                return TypeInfo::createString();
            case 'integer':
                return TypeInfo::createInt();
            case 'double':
                return TypeInfo::createFloat();
            case 'array':
                return $this->guessArrayType($value);
            case 'object':
                return $this->guessObjectType($value);
        }
    }

    private function guessArrayType(array $value): TypeInfoInterface
    {
        if (count($value) < 1) {
            return TypeInfo::createArray();
        }
        $hasStringKeys = false;
        $hasIntKeys = false;
        /** @var TypeInfo|null $lastType */
        $childType = null;
        foreach ($value as $key => $childValue) {
            $hasStringKeys = $hasStringKeys || is_string($key);
            $hasIntKeys = $hasIntKeys || is_int($key);
            $type = $this->guessType($childValue);
            $childType = $childType ? TypeInfo::add($type, $childType) : $type;
        }
        $keyType = match ([$hasStringKeys, $hasIntKeys]) {
            [true, false] => TypeInfo::createString(),
            [true, true] => TypeInfo::createUnion([TypeInfo::createString(), TypeInfo::createInt()]),
            default => TypeInfo::createInt(),
        };
        return TypeInfo::createArrayOf($childType, $keyType);
    }

    #[Pure]
    private function guessObjectType(object $value): TypeInfoInterface
    {
        $className = get_class($value);
        return TypeInfo::createClass($className);
    }
}
