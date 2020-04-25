<?php

namespace App\Controller;

use App\Entity\Lines;
use App\Entity\Exercise;
use App\Form\ParsonType;
use App\Form\ExerciseType;
use Symfony\Flex\Unpack\Result;
use App\Repository\ClassesRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExerciseController extends AbstractController
{
    /**
     * Afficher la liste des exrcices
     * @Route("/teacher/exercice/{id<\d+>?}", name="exercise_index")
     */
    public function index(ClassesRepository $repo,$id)
    {
        $result= $repo->findAll();
        if($id === null){
            $first=$result[0]->getId();
        }else{
            $first=$id;
        }
        return $this->render('exercise_teacher/index.html.twig', [
            'repos' =>$result,
            'first' =>$first,
        ]);
    }
    /**
     * Creation d'exercice 
     * @Route("/teacher/exercice/create", name="exercise_create")
     *
     * @return void
     */
    public function create(ObjectManager $manager,Request $request){
        $exercise=new Exercise();
        $form=$this->createForm(ExerciseType::class,$exercise);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $exercise->settype("normal");
            $manager->persist($exercise);
            $manager->flush();
            $this->addFlash('success text-center',"l'exercice ".$exercise->getTitle()." est enregistrer");
            return $this->redirectToRoute("exercise_index");

        }
        return $this->render('exercise_teacher/create.html.twig',["form"=>$form->createView()]);
    }

    /**
     * visualiser le cours
     * @Route("/teacher/exercice/show/{id}", name="exercise_show")
     *
     * @return void
     */
    public function show(Exercise $exercise)
    {

        return $this->render("exercise_teacher/show.html.twig", ["exercise" => $exercise]);
    }

    /**
     * modifier l'exercise
     * @Route("/teacher/exercise/edit/{id}" , name="exercise_edit")
     */

    public function edit(Exercise $exercise, ObjectManager $manager, Request $request)
    {
        
        if (!empty($exercise->getClasses())) {
            
            $classe=$exercise->getClasses();
        }
        $form = $this->createForm(ExerciseType::class, $exercise);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           $exercise->setClasses($classe);

       

            $manager->persist($exercise);
            $manager->flush();
            $this->addFlash("success text-center", "l'exercise: " . $exercise->getTitle() . " est mise à jour");
            return  $this->redirectToRoute("exercise_index");
        }

        return $this->render("exercise_teacher/edit.html.twig", ['form' => $form->createView()]);
    }
    /**
     * Supprimer un exercice
     * @Route("/teacher/exercice/remove/{id}", name="exercise_remove")
     *
     * @return void
     */
    public function remove(ObjectManager $manager, Exercise $exercise)
    {
        $manager->remove($exercise);
        $manager->flush();
        $this->addFlash("success text-center", "l'exercice " . $exercise->getTitle() . " est supprime");
        return $this->redirectToRoute("exercise_index");
    }
    //------------------exercie parson---------------------------------------------------


    /**
     * créer un exercie parson
     * @Route("/teacher/exercice/parson/create/{id<\d+>?}", name="parson_create")
     *
     * @return void
     */
public function parsonCreate(ObjectManager $manager,Request $request,$id){
    if( $id==null){

        $exercise=new Exercise();
    }else{
       $repo=$manager->getRepository("App\Entity\Exercise");
       $exercise=$repo->findOneBy(['id' => $id]);

    }
$form=$this->createForm(ParsonType::class,$exercise);
$form->handleRequest($request);
if($form->isSubmitted() && $form->isValid()){
    $exercise->settype("parson");
    foreach($exercise->getLinesExercise() as $line){
        $line->setExercise($exercise);
        $manager->persist($line);
    }
    $manager->persist($exercise);
    $manager->flush();
    $this->addFlash("success text-center","l'exercice parson ".$exercise->getTitle(). " est enregistré");
    return $this->redirectToRoute("exercise_index");
}



return $this->render("exercise_teacher/parson.html.twig",[
    "form" =>$form->createView()
]);

}
//---------------------------------------------------------------------------
    /**
     * visualiser le cours
     * @Route("/teacher/exercice/parson/show/{id}", name="parson_show")
     *
     * @return void
     */
    public function parsonShow(Exercise $exercise)
    {

        return $this->render("exercise_teacher/parsonShow.html.twig", ["exercise" => $exercise]);
    }






}
