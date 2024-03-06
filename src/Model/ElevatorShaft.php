<?php

declare(strict_types=1);

namespace App\Model;


/**
 * Lift akna amely metszi az emeleteket és a lift mozgás tere
 */
class ElevatorShaft
{

    /**
     * @var Elevator
     */
    protected $elevator;

    /**
     * @var Floor[]
     */
    protected $floors;

    /**
     * @param Elevator $elevator
     * @param Floor[] $floors
     */
    public function __construct(Elevator $elevator, array $floors)
    {
        $this->elevator = $elevator;
        $this->floors = $floors;
    }

    public function getElevator(): Elevator
    {
        return $this->elevator;
    }

    public function getFloors(): array
    {
        return $this->floors;
    }

}