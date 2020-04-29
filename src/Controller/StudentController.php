<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Exercise;
use App\Repository\ClassesRepository;
use App\Repository\ExerciseRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentController extends AbstractController
{
    /**
     * @Route("/student/index/{page<\d+>?1}", name="student_index")
     */
    public function index(ClassesRepository $repo,$page)
    {
        $limit=10;
        $start=$page * $limit - $limit;
        $total=count($repo->findAll());
        //dd($total);
        $pages=ceil($total / $limit);
        $result=$repo->findBy([],["updateDate"=>"DESC"],$limit,$start);



        return $this->render('student/index.html.twig', [
            'results' => $result,
            'pages'   =>$pages,
            'page'    =>$page
        ]);
    }
    /**
     * Afficher un cours
     * @Route("/student/classes/show/{slug}", name="student_classes_show")
     *
     * @return void
     */
    public function classesShow(Classes $classes){

return $this->render("student/classesShow.html.twig",[ "classes" => $classes]);
    }
    /**
     * Afficher la liste des exercices d'un cours
     * @Route("/student/classes/execice/show/{slug}", name="student_exercise_classes")
     *
     * @return void
     */
    public function execiseShow(Classes $classes){

return $this->render("student/classesExercise.html.twig",["classes" => $classes]);
    }
    /**
     * affiche un exercice de type normal
     * @Route("/student/classes/execice/show/normal/{id}", name="student_exercise_normal")
     */ 

    public function execiseShowNormal(Exercise $exercise){

return $this->render("student/exerciseShowNormal.html.twig",["exercise" => $exercise]);
    }
    /**
     * affiche un exercice de type normal
     * @Route("/student/classes/execice/show/parson/{id}", name="student_exercise_parson")
     */ 

    public function execiseShowParson(Exercise $exercise){

return $this->render("student/exerciseShowParson.html.twig",["exercise" => $exercise]);
    }
    /**
     * @Route("/student/execise/index/{page<\d+>?1}", name="student_exercise_index")
     */
    public function execiseIndex(ExerciseRepository $repo, $page)
    {
        $limit = 10;
        $start = $page * $limit - $limit;
        $total = count($repo->findAll());
        //dd($total);
        $pages = ceil($total / $limit);
        $result = $repo->findBy([], ["dateCreate" => "DESC","type"=>"ASC"], $limit, $start);



        return $this->render('student/exerciseIndex.html.twig', [
            'results' => $result,
            'pages'   => $pages,
            'page'    => $page
        ]);
    }
}
