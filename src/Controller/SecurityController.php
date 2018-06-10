<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotPasswordType;
use App\Form\NewPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Mailjet\Resources;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 21/04/2018
 * Time: 15:25
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("/forgot_password", name="forgot_password")
     */

    public function forgotPasswordAction(Request $request)
    {
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $repository = $this
                ->getDoctrine()
                ->getRepository(User::class);
            if ($user = $repository->findOneBy(array('email' => $data['email']))) {
                $user->setToken(base64_encode(random_bytes(10)));

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();


                $mj = new \Mailjet\Client($this->getParameter('apikey'), $this->getParameter('apisecret'), true, ['version' => 'v3.1']);
                $body = [
                    'Messages' => [
                        [
                            'From' => [
                                'Email' => "adacvg@adacvg973.fr",
                                'Name' => "adacvg973",
                            ],
                            'To' => [
                                [
                                    'Email' => $data['email'],
                                    'Name' => $user->getUsername()
                                ]
                            ],
                            'Subject' => "Votre demande de réinitialisation de mot de passe",
                            'HTMLPart' => "<p>Veuillez trouver ci-dessous le lien permettant de réinitialiser votre mot de passe:</p>
                            <p><a href=\"{{var:url:''}}\">{{var:url:''}}</a></p>
                            ",
                            'TemplateLanguage' => true,
                            'Variables' => [

                                'url' =>$request->getSchemeAndHttpHost()."/register/".$key=$user->getToken()
                            ]
                        ]
                    ]
                ];
                $response = $mj->post(Resources::$Email, ['body' => $body]);
                if ($response->success() && $response->getData()) {
                    $this->addFlash('info', 'Votre demande a été prise en compte. Vous
                recevrez sous peu un lien vous permettant de réinitialiser votre mot de passe.');
                    return $this->redirectToRoute('homepage');

                } else {
                    $this->addFlash('info', 'Problème de connexion. Recommencez plus tard.');
                };
            }


        }
        return $this->render('security/forgotPassword.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/register/{key}", name="register")
     */
    public function newPasswordAction(EntityManagerInterface $em, Request $request, UserRepository $userRepository, $key)
    {
        $form = $this->createForm(NewPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $userRepository->getUser($key);

            $encoded = $this->get('security.password_encoder')->encodePassword($user, $data['password']);
            $user->setPassword($encoded);
            $user->setToken(null);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', "Votre mot de passe a été réinitialisé!");
            return $this->redirectToRoute('homepage');
        }

        return $this->render('security/newPassword.html.twig', array(
            'form' => $form->createView(),
        ));
    }


}