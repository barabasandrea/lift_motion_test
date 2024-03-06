<?php

declare(strict_types=1);

namespace App\Model;


/**
 * Az emeleten levő lift "hívó"
 */
class LiftNavigator {

    protected $destinations = [];

    /**
     * @var ElevatorShaft[]
     */
    protected $elevatorShafts;

    /**
     * @param ElevatorShaft[] $elevatorShafts
     */
    public function __construct(array $elevatorShafts) {
        $this->elevatorShafts = $elevatorShafts;

        foreach ($elevatorShafts as $shaftId => $shaft) {
            $this->destinations[$shaftId] = $shaft->getElevator()->getCurrentPosition();
        }
    }

    public function getShafts(): array
    {
        return $this->elevatorShafts;
    }

    public function callInFloor(int $floor) {

        // hivjuk: 5
        //   liftakna:
        //        lift: 0
        //        lift: 6
        $distance = [];

        foreach ($this->elevatorShafts as $key => $shaft) {
            // adott lift aktuális pozicíó
            $distance[$key] = abs($floor - $shaft->getElevator()->getCurrentPosition());
        }

        $mustSendThisLift = array_search(min($distance), $distance, true);
        $elevatorShaft = $this->elevatorShafts[$mustSendThisLift];

        $this->destinations[$mustSendThisLift] = $floor;

        foreach ($elevatorShaft->getFloors() as $currentFloor) {
            if ($floor < $elevatorShaft->getElevator()->getCurrentPosition()) {
                $currentFloor->getUpDownDisplay()->setDown();
            } else {
                $currentFloor->getUpDownDisplay()->setUp();
            }
        }
    }

    public function pressDestination(int $elevatorShaftId, int $destinationFloor)
    {
        $elevatorShaft = $this->elevatorShafts[$elevatorShaftId];
        $this->destinations[$elevatorShaftId] = $destinationFloor;

        foreach ($elevatorShaft->getFloors() as $currentFloor) {
            if ($destinationFloor < $elevatorShaft->getElevator()->getCurrentPosition()) {
                $currentFloor->getUpDownDisplay()->setDown();
            } else {
                $currentFloor->getUpDownDisplay()->setUp();
            }
        }
    }

    public function getElevatorShaftIdWhereElevatorInFloor(int $floor) {
        foreach ($this->elevatorShafts as $key => $shaft) {
            if ($shaft->getElevator()->getCurrentPosition() === $floor) {
                return $key;
            }
        }

        return null;
    }

    public function move(): bool
    {
        $moved = false;
        foreach ($this->destinations as $key => $destionationFloor) {
            $currentElevator = $this->elevatorShafts[$key]->getElevator();
            $currentPosition = $currentElevator->getCurrentPosition();

            if ($destionationFloor<$currentPosition) {
                $currentElevator->moveDown();
                $moved = true;
            } elseif ($destionationFloor>$currentPosition) {
                $moved = true;
                $currentElevator->moveUp();
            } else {
                foreach ($this->elevatorShafts[$key]->getFloors() as $currentFloor) {
                    $currentFloor->getUpDownDisplay()->clearStatus();
                }
            }
        }


        return (bool) $moved;
    }

}