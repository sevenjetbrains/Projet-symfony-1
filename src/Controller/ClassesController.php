<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClassesController extends AbstractController
{
    /**
     * @Route("/teacher/classes", name="classes_teacher")
     * @IsGranted("ROLE_TEACHER")
     */
    public function classes()
    {
        return $this->render('classes_teacher/index.html.twig', [
           
        ]);
    }
}
