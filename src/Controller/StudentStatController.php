<?php

namespace App\Controller;

use App\Repository\ListExerciseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StudentStatController extends AbstractController
{
    /**
     * @Route("/student/stat", name="exercise_stat")
     */
    public function index(ListExerciseRepository $repo)
    {
$user=$this->getUser();
$listExercise=$repo->findBy(["studentTry"=>$user],["date"=>"DESC"]);

        return $this->render('student/studentStat.html.twig', [
            'listexercise' => $listExercise
        ]);
    }
}
