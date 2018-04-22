<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 21/04/2018
 * Time: 15:25
 */
class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(){
        return $this->render('home/home.html.twig');

    }


}