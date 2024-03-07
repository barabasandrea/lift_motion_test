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

    /**
     * @var array
     */
    protected $segments = [];

    /**
     * @return array
     */
    public function displayNumber():array {
        $this->segments = $this->getSegments();
        return array_map('intval', $this->segments);
    }

    /**
     * @return int
     */
    public function show(): int
    {
        return $this->number;
    }

    /**
     * @param int $currentPosition
     * @return void
     */
    public function setNumber(int $currentPosition)
    {
        $this->number = $currentPosition;
    }

    /*
     *     ***a**
     *   f *    * b
     *     *    *
     *     *    *
     *     **g***
     *     *    *
     *   e *    * c
     *     *    *
     *     **d***
     *
     * */

    /**
     * @return array
     */
    public function getSegments(): array
    {
        switch ($this->number) {
            case 1:
                        #a      b       c       d        e      f       g
                return [false,  false,  false,  false,   true,  true,   false];
            case 2:
                return [true,   true,   false,  true,    true,  false,  true];
            case 3:
                return [true,   true,   true,   true,   false,   false,  true];
            case 4:
                return [false,   true,   true,   false,   false,   true,  true];
            case 5:
                return [true,   false,   true,   true,   false,   true,  true];
            case 6:
                return [true,   false,   true,   true,   true,   true,  true];
            default:
                return [true,   true,   true,   true,   true,   true,  false];
        }
    }

}