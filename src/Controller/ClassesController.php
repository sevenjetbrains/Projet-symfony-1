<?php

namespace App\Controller;


use App\Entity\Classes;

use App\Form\ClassesType;
use App\Repository\ClassesRepository;
use DateTimeZone;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ClassesController extends AbstractController
{
    /**
     * @Route("/teacher/classes", name="classes_teacher")
     * @IsGranted("ROLE_TEACHER")
     */
    public function classes(ClassesRepository $repo)
    {
        return $this->render('classes_teacher/index.html.twig', [
            "repos" => $repo->findAll(),

        ]);
    }
    /**
     * Creation de cour
     * @Route("/teacher/create",name="classes_create")
     *
     * @return Response
     */
    public function createClasses(ObjectManager $manager, Request $request)
    {
        $classe = new Classes();

        

        $form = $this->createForm(ClassesType::class, $classe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $classe->setAuthor($this->getUser());

            $manager->persist($classe);
            $manager->flush();
            $this->addFlash("success text-center", "le cour est enregistrer");
           return  $this->redirectToRoute("classes_teacher");
        }



        return $this->render("classes_teacher/create.html.twig", [
            "form" => $form->createView(),
        ]);
    }
    /**
     * visualiser le cour
     * @Route("/teacher/show/{slug}", name="classes_show")
     *
     * @return void
     */
    public function show(Classes $classe)
    {

        return $this->render("classes_teacher/show.html.twig", ["classe" => $classe]);
    }
    /**
     * modifier le cour
     * @Route("/teacher/edit/{id}" , name="classes_edit")
     */

    public function edit(Classes $classe, ObjectManager $manager, Request $request)
    {
        $form = $this->createForm(ClassesType::class, $classe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $date=new \DateTime();
            $date->setTimezone(new DateTimeZone('Europe/Paris'));
            
            $classe->setUpdateDate($date);


            $manager->persist($classe);
            $manager->flush();
            $this->addFlash("success text-center", "le cour " . $classe->getTitle() . " est mise à jour");
           return  $this->redirectToRoute("classes_teacher");

        }

        return $this->render("classes_teacher/edit.html.twig", ['form' => $form->createView()]);
    }
    /**
     * Supprimer un cours
     * @Route("/teacher/remove/{id}", name="classes_remove")
     *
     * @return void
     */
    public function remove(ObjectManager $manager,Classes $classe){
        $manager->remove($classe);
        $manager->flush();
        $this->addFlash("success text-center","le cours ".$classe->getTitle()." est supprime");
        return $this->redirectToRoute("classes_teacher");


    }
}
