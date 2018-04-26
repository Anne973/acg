<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventController extends Controller
{
    /**
     * @Route("/calendrier", name="calendrier")
     */
    public function indexAction(EventRepository $eventRepository)
    {
        $events=$eventRepository -> getEvents();
        return $this->render('event/index.html.twig', array('events' => $events));
    }
}
