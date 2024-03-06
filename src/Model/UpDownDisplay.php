<?php

declare(strict_types=1);

namespace App\Model;

/**
 * Emeleteken levő kijelző, mely adott liftnek az irányát mutatja
 */
class UpDownDisplay {

    const UP = 'UP';
    const DOWN = 'DOWN';
    const BLANK = 'BLANK';

    /**
     * @var string
     */
    private $status = self::BLANK;

    public function setUp() {
        $this->status = self::UP;
    }

    public function setDown() {
        $this->status = self::DOWN;
    }

    public function clearStatus() {
        $this->status = self::BLANK;
    }

    public function show(): string
    {
        return $this->status;
    }

}