<?php

declare(strict_types=1);

namespace App\Model;

/**
 * Liftben levő kijelző, mely a lift pillanatnyi mozgásban levő pozicíóját mutatja
 */
class Display {

    /**
     * @var int
     */
    protected $number;

    public function displayNumber(int $number) {
        $this->number = $number;
    }

    public function show(): int
    {
        return $this->number;
    }

    public function setNumber(int $currentPosition)
    {
        $this->number = $currentPosition;
    }
}