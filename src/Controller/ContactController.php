<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 22/04/2018
 * Time: 11:23
 */

namespace App\Controller;


use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends Controller

{
    /**
     * @Route("/contact", name="contact")
     */
    public function indexAction(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if($form ->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $message= (new \Swift_Message('Contact to ADACVG'))
                ->setFrom($data['email'])
                ->setTo('anne.derenoncourt@gmail.com')
                ->setBody(
                    $this->renderView(
                        'Emails/contact.html.twig',
                        array('data' => $data)
                    ),
                    'text/html'
                );
            $mailer->send($message);
            $this->addFlash('notice', 'Votre message a été envoyé. Merci!');
            return $this->redirectToRoute('contact');
        }
        return $this->render('contact/contact.html.twig', array('form' => $form->createView()));
    }


}