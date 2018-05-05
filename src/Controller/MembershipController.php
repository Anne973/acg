<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 22/04/2018
 * Time: 11:23
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
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

    /**
     * @Route("/download", name="download")
     */
    public function downloadAction()
    {
        $pdfPath = $this->getParameter('dir.downloads').'/bulletin_adhesion.pdf';

        return $this->file($pdfPath, 'dossier-bulletin-adhesion',ResponseHeaderBag::DISPOSITION_INLINE);
    }


}