<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Display;
use App\Model\Elevator;
use App\Model\ElevatorShaft;
use App\Model\Floor;
use App\Model\LiftNavigator;
use App\Model\UpDownDisplay;
use Symfony\Component\HttpFoundation\Response;

class LiftController
{

    private function renderRow($liftNavigator) {
        $template = '<tr>';
        foreach ($liftNavigator->getShafts() as $key => $shaft) {

            $template .= '<td width="50%"><pre>';
            $template .= '<h1>Elevator ' . $key . '</h1>';
            $template .= sprintf('Lift %s position: %s', $key, $shaft->getElevator()->getDisplay()->show());
            $template .= '<h2>Door statuses:</h2>';
            foreach ($shaft->getFloors() as $floorNumber => $floor) {
                $template .= sprintf('<br>Up down display show in floor %s : %s', $floorNumber, $floor->getUpDownDisplay()->show());
            }

            $template .= '</pre><hr></td>';
        }
        $template .= '</tr>';

        return $template;
    }

    public function motion(): Response
    {
        // from parameters
        $callInFloor = 5;
        $pressDestination = 3;

        $elevatorShafts = [];

        $elevatorShafts[] = new ElevatorShaft(new Elevator(new Display(), 0), [
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
        ]);

        $elevatorShafts[] = new ElevatorShaft(new Elevator(new Display(), 6), [
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
        ]);


        $liftNavigator = new LiftNavigator($elevatorShafts);

        $liftNavigator->callInFloor($callInFloor);


        $template = sprintf('<h1>I want to go from the %s floor to the %s floor</h1>', $callInFloor, $pressDestination);

        $template .= '<table width="100%">';


        $template .= '<h2>Calling</h2>';
        do {
            $template .= $this->renderRow($liftNavigator);
        } while ($liftNavigator->move());


        $template .= '</table>';
        $template .= '<h4>Lift megerkezett az emberunkert</h4>';
        $template .= '<hr>';
        $template .= '<h2>Emberunk beszall es elinditja a liftet a celjahoz</h2>';


        $template .= '<table width="100%">';
        $liftNavigator->pressDestination(
            $liftNavigator->getElevatorShaftIdWhereElevatorInFloor($callInFloor),
            $pressDestination
        );
        do {
            $template .= $this->renderRow($liftNavigator);
        } while ($liftNavigator->move());

        $template .= '</table>';
        $template .= 'DONE';

        return new Response(
            sprintf('<html><body>%s</body></html>', $template)
        );
    }


}