<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Repository\ClassesRepository;
use App\Repository\ExerciseRepository;
use App\Repository\ListExerciseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TeacherStatController extends AbstractController
{
    /**
     * @Route("/teacher/stat", name="teacher_stat")
     */
    public function index(ClassesRepository $repoClass)
    {
 $user=$this->getUser();
 $classes=$repoClass->findBy(["author"=>$user]);



        return $this->render('exercise_teacher\teacherStat.html.twig', [
            'classes' => $classes,
        ]);
    }
    /**
     * @Route("/teacher/stat/exercise/{id}", name="teacher_stat_detail")
     */
    public function detail(ExerciseRepository $repo,$id,ListExerciseRepository $list)
    {
      //  ini_set('max_execution_time', 0);
        $tab1=[];
        $tab2=[];
        $exercise=$repo->findOneBy(["id"=>$id]);
        $result=$list->findBy(["exercise"=>$exercise]);

for($i=0;$i<count($result);$i++){
    $tab1["nom"]=$result[$i]->getStudentTry()->getCompletName();
    $tab1["status"]=$result[$i]->getStatus();
    $tab1["nomberTry"]=$result[$i]->getNomberTry();
    $tab2[$i]=$tab1;
}

dump($tab2);
        return $this->render('exercise_teacher\detail.html.twig', [
            'result' => $tab2,
        ]);
    }
}
