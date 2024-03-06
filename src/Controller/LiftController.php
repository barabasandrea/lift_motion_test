<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Display;
use App\Model\Elevator;
use App\Model\ElevatorShaft;
use App\Model\Floor;
use App\Services\LiftNavigatorService;
use App\Model\UpDownDisplay;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LiftController extends AbstractController
{

    public function motion(int $callInFloor, int $pressDestination): Response
    {
        $elevatorShafts = [];

        $elevatorShafts[] = $this->createElevatorShafts(0);
        $elevatorShafts[] = $this->createElevatorShafts(6);

        $liftNavigator = new LiftNavigatorService($elevatorShafts);

        $liftNavigator->callInFloor($callInFloor);

        $template = sprintf('<h1>I want to go from the %s floor to the %s floor</h1>', $callInFloor, $pressDestination);

        $template .= '<table width="100%">';


        $template .= '<h2>Calling</h2>';

        do {
            $template .= $this->renderRow($liftNavigator);
        } while ($liftNavigator->move());


        $template .= '</table>';
        $template .= sprintf('<h2>The elevator has arrived at the %sth floor</h2>', $callInFloor) ;
        $template .= '<hr>';
        $template .= sprintf('<h2>I get into the elevator and head to the %srd floor</h2>', $pressDestination);


        $template .= '<table width="100%">';
        $liftNavigator->pressDestination(
            $liftNavigator->getElevatorShaftIdWhereElevatorInFloor($callInFloor),
            $pressDestination
        );
        do {
            $template .= $this->renderRow($liftNavigator);
        } while ($liftNavigator->move());

        $template .= '</table>';
        $template .= '<h2>DONE</h2>';

        return new Response(
            sprintf('<html><body>%s</body></html>', $template)
        );
/*
        return $this->render('lift/motion.html.twig', [
            'liftNavigator' => $liftNavigator,
            'callInFloor' => $callInFloor,
            'pressDestination' => $pressDestination,
        ]);
*/
    }

    private function renderRow($liftNavigator): string
    {
        $template = '<tr>';

        foreach ($liftNavigator->getShafts() as $key => $shaft) {

            $actualPosition = $shaft->getElevator()->getDisplay()->show();
            $segments = implode(':', $shaft->getElevator()->getDisplay()->displayNumber($actualPosition));

            $template .= '<td width="50%"><pre>';
            $template .= '<h1>Elevator ' . $key . '</h1>';
            $template .= sprintf('Lift %s position: %s, %s', $key, $actualPosition, $segments);
            $template .= '<h2>Door statuses:</h2>';
            foreach ($shaft->getFloors() as $floorNumber => $floor) {
                $template .= sprintf('<br>Up down display show in floor %s : %s', $floorNumber, $floor->getUpDownDisplay()->show());
            }

            $template .= '</pre><hr></td>';
        }
        $template .= '</tr>';

        return $template;
    }

    /**
     * @param int $currentPosition
     * @return ElevatorShaft
     */
    public function createElevatorShafts(int $currentPosition): ElevatorShaft
    {
        return new ElevatorShaft(new Elevator(new Display(), $currentPosition), [
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
            new Floor(new UpDownDisplay()),
        ]);
    }


}