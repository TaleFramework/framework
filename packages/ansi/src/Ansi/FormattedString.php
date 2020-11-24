<?php declare(strict_types=1);

namespace Tale\Ansi;

use JetBrains\PhpStorm\Pure;
use Stringable;
use function Tale\ansi_escape_sgr;

final class FormattedString implements Stringable
{
    public function __construct(
        private string $content,
        private array $selectGraphicRenditions = [],
    ) {}

    #[Pure]
    public function italic(): self
    {
        return new self($this->content, [...$this->selectGraphicRenditions, SelectGraphicRendition::STYLE_ITALIC]);
    }

    #[Pure]
    public function bold(): self
    {
        return new self($this->content, [...$this->selectGraphicRenditions, SelectGraphicRendition::STYLE_BOLD]);
    }

    #[Pure]
    public function underline(): self
    {
        return new self($this->content, [...$this->selectGraphicRenditions, SelectGraphicRendition::STYLE_UNDERLINE]);
    }

    #[Pure]
    public function blink(): self
    {
        return new self($this->content, [...$this->selectGraphicRenditions, SelectGraphicRendition::STYLE_BLINK]);
    }

    #[Pure]
    public function blinkRapid(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::STYLE_BLINK_RAPID,
        ]);
    }

    #[Pure]
    public function faint(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::STYLE_INTENSITY_FAINT,
        ]);
    }

    #[Pure]
    public function bright(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::STYLE_INTENSITY_BRIGHT,
        ]);
    }

    #[Pure]
    public function negative(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::STYLE_NEGATIVE,
        ]);
    }

    #[Pure]
    public function conceal(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::STYLE_CONCEAL,
        ]);
    }

    #[Pure]
    public function strikeThrough(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::STYLE_STRIKETHROUGH,
        ]);
    }

    #[Pure]
    public function black(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::COLOR_FG_BLACK,
        ]);
    }

    #[Pure]
    public function red(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::COLOR_FG_RED,
        ]);
    }

    #[Pure]
    public function green(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::COLOR_FG_GREEN,
        ]);
    }

    #[Pure]
    public function yellow(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::COLOR_FG_YELLOW,
        ]);
    }

    #[Pure]
    public function blue(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::COLOR_FG_BLUE,
        ]);
    }

    #[Pure]
    public function purple(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::COLOR_FG_PURPLE,
        ]);
    }

    #[Pure]
    public function cyan(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::COLOR_FG_CYAN,
        ]);
    }

    #[Pure]
    public function white(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::COLOR_FG_WHITE,
        ]);
    }

    #[Pure]
    public function blackBackground(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::COLOR_BG_BLACK,
        ]);
    }

    #[Pure]
    public function redBackground(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::COLOR_BG_RED,
        ]);
    }

    #[Pure]
    public function greenBackground(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::COLOR_BG_GREEN,
        ]);
    }

    #[Pure]
    public function yellowBackground(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::COLOR_BG_YELLOW,
        ]);
    }

    #[Pure]
    public function blueBackground(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::COLOR_BG_BLUE,
        ]);
    }

    #[Pure]
    public function purpleBackground(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::COLOR_BG_PURPLE,
        ]);
    }

    #[Pure]
    public function cyanBackground(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::COLOR_BG_CYAN,
        ]);
    }

    #[Pure]
    public function whiteBackground(): self
    {
        return new self($this->content, [
            ...$this->selectGraphicRenditions,
            SelectGraphicRendition::COLOR_BG_WHITE,
        ]);
    }

    #[Pure]
    public function __toString(): string
    {
        if (count($this->selectGraphicRenditions) < 1) {
            return $this->content;
        }
        return ansi_escape_sgr($this->selectGraphicRenditions)
            . $this->content
            . ansi_escape_sgr([SelectGraphicRendition::STYLE_NONE]);
    }
}
