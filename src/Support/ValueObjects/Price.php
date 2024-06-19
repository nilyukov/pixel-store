<?php

namespace Support\ValueObjects;

use InvalidArgumentException;
use Stringable;
use Support\Traits\Makeable;

class Price implements Stringable
{
    use Makeable;

    private array $currencies = [
        'RUB' => '₽',
    ];

    public function __construct(
        private readonly int $value,
        private readonly string $currency = 'RUB',
        private readonly int $precision = 100
    )
    {
        if ($this->value < 0) {
            throw new InvalidArgumentException('Price cannot be negative');
        }

        if (!array_key_exists($this->currency, $this->currencies)) {
            throw new InvalidArgumentException('Currency is not supported');
        }
    }

    public function raw(): float|int
    {
        return $this->value;
    }

    public function value(): float|int
    {
        return $this->value / $this->precision;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function symbol()
    {
        return $this->currencies[$this->currency];
    }

    public function __toString()
    {
        return number_format($this->value(), 0, ',', ' ') . ' ' . $this->symbol();
    }
}
