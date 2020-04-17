<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Form\TeacherType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeTeacherController extends AbstractController
{
    /**
     * @Route("/home/teacher", name="home_teacher")
     */
    public function index()
    {
        return $this->render('account_teacher/home.html.twig', [
            
        ]);
    }
/**
 * 
 * @Route("/account/teacher/registration", name="registration_teacher")
 *
 * @return void
 */
    public function registration(ObjectManager $manager,Request $request, UserPasswordEncoderInterface $encoder){
         $teacher=new Teacher();
        $form=$this->createForm(TeacherType::class,$teacher);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $hash=$encoder->encodePassword($teacher,$teacher->getHash());
            $teacher->setHash($hash);


            $manager->persist($teacher);
            $manager->flush();
            $this->addFlash("success text-center", "Vos etez inscrits");
            return $this->redirectToRoute('registration_teacher');
        }


        return $this->render("account_teacher/registration.html.twig",[
            'form'=>$form->createView()]);


    }
}
