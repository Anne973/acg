<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 22/04/2018
 * Time: 11:23
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends Controller

{
    /**
     * @Route("/calendrier", name="calendrier")
     */
    public function indexAction()
    {
        return $this->render('events/calendar.html.twig');
    }


}