<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home.html.twig'
            
        );
    }
    /**
     * @route("/inscription",name="registration_student")
     */

    public function registration(ObjectManager $manager,Request $request, UserPasswordEncoderInterface $encoder){
        $student=new Student();
        $form=$this->createForm(StudentType::class,$student);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $hash=$encoder->encodePassword($student,$student->getHash());
            $student->setHash($hash);


            $manager->persist($student);
            $manager->flush();
            $this->addFlash("success text-center", "Vos etez inscrits");
            return $this->redirectToRoute('registration_student');
        }


        return $this->render("account/registration.html.twig",[
            'form'=>$form->createView()
        ]);
    }
}
