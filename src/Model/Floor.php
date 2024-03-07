<?php

declare(strict_types=1);

namespace App\Model;


/**
 * Emelet, mely mutatja a lift irányát
 */
class Floor {

    /**
     * @var UpDownDisplay
     */
    private $upDownDisplay;

    /**
     * @param UpDownDisplay $upDownDisplay
     */
    public function __construct(UpDownDisplay $upDownDisplay )
    {
        $this->upDownDisplay = $upDownDisplay;
    }

    /**
     * @return UpDownDisplay
     */
    public function getUpDownDisplay(): UpDownDisplay
    {
        return $this->upDownDisplay;
    }

}