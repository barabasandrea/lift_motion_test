<?php

declare(strict_types=1);

namespace App\Model;

/**
 * Emeleteken levő kijelző, mely adott liftnek az irányát mutatja
 */
class UpDownDisplay {

    /**
     * @var string
     */
    private $status = 'BLANK';

    public function setUp() {
        $this->status = 'UP';
    }

    public function setDown() {
        $this->status = 'DOWN';
    }

    public function clearStatus() {
        $this->status = 'BLANK';
    }

    public function show(): string
    {
        return $this->status;
    }

}