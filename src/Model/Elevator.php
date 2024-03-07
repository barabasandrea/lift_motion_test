<?php

declare(strict_types=1);

namespace App\Model;


/**
 * Lift melynek van egy kijelzője, és tudja az aktuális pozicíóját
 */
class Elevator {

    /**
     * @var Display
     */
    protected $display;

    /**
     * @var int
     */
    protected $currentPosition;

    /**
     * @param Display $display
     * @param int $currentPosition
     */
    public function __construct(Display $display, int $currentPosition = 0) {
        $this->display = $display;
        $this->currentPosition = $currentPosition;

        $this->display->setNumber($currentPosition);
    }

    /**
     * @return int
     */
    public function getCurrentPosition(): int
    {
        return $this->currentPosition;
    }

    /**
     * @return Display
     */
    public function getDisplay(): Display
    {
        return $this->display;
    }

    /**
     * @return void
     */
    public function moveUp() {
        $this->currentPosition++;
        $this->display->setNumber($this->currentPosition);
    }

    /**
     * @return void
     */
    public function moveDown() {
        $this->currentPosition--;
        $this->display->setNumber($this->currentPosition);
    }

}