<?php declare(strict_types=1);

namespace Tale\VarDumper;

use Psr\Http\Message\StreamInterface;
use Tale\Ansi\FormattedString;
use Tale\VarDumperInterface;
use Vtiful\Kernel\Format;

final class AnsiVarDumper implements VarDumperInterface
{
    private array $dumpedObjects = [];

    public function dump(StreamInterface $stream, mixed $value): void
    {
        $this->write($stream, $value);
        $stream->write(PHP_EOL);
    }

    private function write(StreamInterface $stream, mixed $value, int $level = 0): void
    {
        switch (strtolower(gettype($value))) {
            case 'boolean':
                $stream->write((string)(new FormattedString($value ? 'true' : 'false'))->blue());
                break;
            case 'null':
                $stream->write((string)(new FormattedString('null'))->blue());
                break;
            case 'integer':
            case 'double':
                $stream->write((string)(new FormattedString((string)$value))->blue());
            break;
            case 'string':
                $stream->write((string)(new FormattedString("\"{$value}\""))->red());
                break;
            case 'array':
                $this->writeIterable($stream, $value, $level);
                break;
            case 'object':
                $this->writeObject($stream, $value, $level);
                break;
            case 'resource':
            case 'resource (closed)':
                $stream->write((string)(new FormattedString('resource'))->blue());
                break;
            default:
                $stream->write((string)(new FormattedString('Unknown'))->faint());
                break;
        }
    }

    private function writeIterable(
        StreamInterface $stream,
        iterable $value,
        int $level = 0,
        string $label = 'array',
    ): void {
        $count = is_countable($value) ? count($value) : null;
        $stream->write((string)(new FormattedString(
            $label . ($count !== null ? ":{$count}" : ''),
        ))->yellow());
        if ($count !== null && $count < 1) {
            return;
        }
        $stream->write((string)(new FormattedString(' [' . PHP_EOL))->yellow());
        $nextKey = 0;
        $dumpCount = 0;
        foreach ($value as $key => $childValue) {
            $stream->write(str_repeat('  ', $level + 1));
            if (is_string($key) || $key !== $nextKey) {
                $this->write($stream, $key);
                $stream->write((string)(new FormattedString(" => "))->yellow());
            }
            $this->write($stream, $childValue, $level + 1);
            $stream->write((string)(new FormattedString(',' . PHP_EOL))->yellow());
            if ($key === $nextKey) {
                $nextKey++;
            }
            $dumpCount++;
            if ($dumpCount > 10) { // TODO: Put this in options object?
                $stream->write(str_repeat('  ', $level + 1));
                $stream->write((string)(new FormattedString('...'))->yellow());
                $stream->write((string)(new FormattedString(',' . PHP_EOL))->yellow());
                break;
            }
        }
        $stream->write(str_repeat('  ', $level));
        $stream->write((string)(new FormattedString(']'))->yellow());
    }

    private function writeObject(StreamInterface $stream, object $value, int $level = 0): void
    {
        $reflection = new \ReflectionClass($value);
        $properties = $reflection->getProperties();
        if (is_iterable($value) && count($properties) < 1) {
            $this->writeIterable($stream, $properties, $level, $reflection->getName());
            return;
        }
        $stream->write((string)(new FormattedString($reflection->getName()))->purple());
        if (in_array($value, $this->dumpedObjects, true)) {
            $stream->write((string)(new FormattedString('*recursion*'))->red());
            return;
        }
        $this->dumpedObjects[] = $value;
        if (count($properties) < 1) {
            return;
        }
        $stream->write((string)(new FormattedString(' {' . PHP_EOL))->purple());
        foreach ($properties as $property) {
            if ($property->isStatic()) {
                continue;
            }
            $public = $property->isPublic();
            $prefix = $public ? (new FormattedString('+'))->green() : (new FormattedString('-'))->red();
            if (!$public) {
                $property->setAccessible(true);
            }
            $stream->write(str_repeat('  ', $level + 1));
            $stream->write((string)$prefix);
            $stream->write((string)(new FormattedString("{$property->getName()}: "))->cyan());
            $this->write($stream, $property->getValue($value), $level + 1);
            $stream->write((string)(new FormattedString(',' . PHP_EOL))->purple());
            if (!$public) {
                $property->setAccessible(false);
            }
        }
        $stream->write(str_repeat('  ', $level));
        $stream->write((string)(new FormattedString('}'))->purple());
    }
}
