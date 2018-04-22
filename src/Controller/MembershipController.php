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

class MembershipController extends Controller

{
    /**
     * @Route("/adhesion", name="adhesion")
     */
    public function indexAction()
    {
        return $this->render('membership/membership.html.twig');
    }


}