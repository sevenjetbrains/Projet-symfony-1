<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * @Route("/student/login", name="account_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        //dd($lastUsername);
        return $this->render('account/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
   
    /**
     * @Route("/student/logout" , name="account_logout")
     *
     * 
     */
    public function logout(){

    }
   
}
