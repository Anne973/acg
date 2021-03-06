<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 22/04/2018
 * Time: 11:23
 */

namespace App\Controller;


use App\Form\ContactType;
use \Mailjet\Resources;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ContactController extends Controller

{
    /**
     * @Route("/contact", name="contact")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $data = $form->getData();
            /*$message= (new \Swift_Message('Contact to ADACVG'))
                ->setFrom($data['email'])
                ->setTo('anne.derenoncourt@gmail.com')
                ->setBody(
                    $this->renderView(
                        'Emails/contact.html.twig',
                        array('data' => $data)
                    ),
                    'text/html'
                );
            $mailer->send($message);*/
            $mj = new \Mailjet\Client($this->getParameter('apikey'), $this->getParameter('apisecret'), true, ['version' => 'v3.1']);
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "adacvg@adacvg973.fr",
                            'Name' => $data['name'],
                        ],
                        'To' => [
                            [
                                'Email' => "ass-dep-anciens-combat@orange.fr",
                                'Name' => "Adacvg"
                            ]
                        ],
                        'Subject' => "Contact to ADACVG",
                        'HTMLPart' => "<p><strong>From : </strong>".$data['email']."</p><p><strong>Objet : </strong>".$data['subject']."</p><p><strong>Message : </strong>".$data['message']."</p>"
                    ]
                ]
            ];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            if($response->success() && $response->getData()){
                $this->addFlash('notice', 'Votre message a été envoyé. Merci!');
                return $this->redirectToRoute('contact');

            }else{
                $this->addFlash('error','Problème de connexion. Retentez plus tard');
            };

        }
        return $this->render('contact/contact.html.twig', array('form' => $form->createView()));
    }


}