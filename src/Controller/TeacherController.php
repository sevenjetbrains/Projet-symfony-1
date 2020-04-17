<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class TeacherController extends AbstractController{


    /**
     * @Route("/teacher/login" , name="teacher_login")
     */
    public function teacherLogin(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('account_teacher/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);

        }


    /**
     * @Route("/teacher/logout" , name="teacher_logout")
     */
    public function teacherLogout(){


      
    }
}