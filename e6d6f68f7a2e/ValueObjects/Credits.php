<?php

declare(strict_types=1);

namespace e6d6f68f7a2e\ValueObjects;

use e6d6f68f7a2e\ValueObjects\Credits\_Exceptions\NegativeCreditsValueError;

final class Credits
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param int $value
     *
     * @throws NegativeCreditsValueError
     */
    private function __construct(int $value)
    {
        if ($value < 0) {
            throw new NegativeCreditsValueError();
        }

        $this->value = $value;
    }

    /**
     * @param int $value
     * @return Credits
     *
     * @throws NegativeCreditsValueError
     */
    public static function withValue(int $value): Credits
    {
        return new Credits($value);
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param Credits $toBeSubtracted
     * @return Credits
     *
     * @throws NegativeCreditsValueError
     */
    public function subtract(Credits $toBeSubtracted): Credits
    {
        return new Credits($this->getValue() - $toBeSubtracted->getValue());
    }

    /**
     * @param Credits $toBeAdded
     * @return Credits
     */
    public function add(Credits $toBeAdded): Credits
    {
        return new Credits($this->getValue() + $toBeAdded->getValue());
    }

    /**
     * @param Credits $other
     * @return bool
     */
    public function isLessThan(Credits $other): bool
    {
        return $this->getValue() < $other->getValue();
    }
}
