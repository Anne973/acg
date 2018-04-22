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

class ContactController extends Controller

{
    /**
     * @Route("/contact", name="contact")
     */
    public function indexAction()
    {
        return $this->render('contact/contact.html.twig');
    }


}