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

class PresentationController extends Controller

{
    /**
     * @Route("/presentation", name="presentation")
     */
    public function indexAction()
    {
        return $this->render('presentation/presentation.html.twig');
    }

    /**
     * @Route("/conseil_administration", name="conseil_administration")
     */
    public function boardAction()
    {
        return $this->render ('presentation/board.html.twig');
    }

    /**
     * @Route("/honorary", name="honorary")
     */
    public function honoraryAction()
    {
        return $this-> render('presentation/former.html.twig');
    }
}