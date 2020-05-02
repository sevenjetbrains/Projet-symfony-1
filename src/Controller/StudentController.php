<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Exercise;
use App\Entity\ListExercise;
use App\Repository\ClassesRepository;
use App\Repository\ExerciseRepository;
use App\Repository\ListExerciseRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class StudentController extends AbstractController
{
    /**
     * @Route("/student/index/{page<\d+>?1}", name="student_index")
     */
    public function index(ClassesRepository $repo, $page)
    {
        $limit = 10;
        $start = $page * $limit - $limit;
        $total = count($repo->findAll());
        //dd($total);
        $pages = ceil($total / $limit);
        $result = $repo->findBy([], ["updateDate" => "DESC"], $limit, $start);



        return $this->render('student/index.html.twig', [
            'results' => $result,
            'pages'   => $pages,
            'page'    => $page
        ]);
    }
    /**
     * Afficher un cours
     * @Route("/student/classes/show/{slug}", name="student_classes_show")
     *
     * @return void
     */
    public function classesShow(Classes $classes)
    {

        return $this->render("student/classesShow.html.twig", ["classes" => $classes]);
    }
    /**
     * Afficher la liste des exercices d'un cours
     * @Route("/student/classes/execice/show/{slug}", name="student_exercise_classes")
     *
     * @return void
     */
    public function execiseShow(Classes $classes)
    {

        return $this->render("student/classesExercise.html.twig", ["classes" => $classes]);
    }
    /**
     * affiche un exercice de type normal
     * @Route("/student/classes/execice/show/normal/{id}", name="student_exercise_normal")
     */

    public function execiseShowNormal(Exercise $exercise)
    {

        return $this->render("student/exerciseShowNormal.html.twig", ["exercise" => $exercise]);
    }
    /**
     * affiche un exercice de type normal
     * @Route("/student/classes/execice/show/parson/{id}", name="student_exercise_parson")
     */

    public function execiseShowParson(Exercise $exercise)
    {

        return $this->render("student/exerciseShowParson.html.twig", ["exercise" => $exercise]);
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
        $result = $repo->findBy([], ["dateCreate" => "DESC", "type" => "ASC"], $limit, $start);



        return $this->render('student/exerciseIndex.html.twig', [
            'results' => $result,
            'pages'   => $pages,
            'page'    => $page
        ]);
    }
    /**
     * Affichage de la page pour résoudre l'exercice
     * @Route("/student/execise/solve/page/{id}", name="student_exercise_solvePage")
     *
     * @return void
     */
    public function solvePage(Exercise $exercise)
    {

        return $this->render("student/solveExercise.html.twig", ["exercise" => $exercise]);
    }

    /**
     * verifier en ajax la solution
     * @Route("/student/execise/solve/save", name="student_exercise_solveSave")
     *
     * @return void
     */
    public function solveSave(ObjectManager $manager, ExerciseRepository $repo, Request $request,ListExerciseRepository $listRepo)
    {
        if ($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(), true);
            $exercise = $repo->find($data["exo"]);
            $user=$this->getUser();
        $listExercise=$listRepo->findOneBy(["studentTry"=>$user,"exercise"=>$exercise]);
if($listExercise == null){

    $listExercise = new ListExercise();
    $listExercise->setStudentTry($user);
}
        
        $repose = [];

        $listSolution = [];
            $compare = $data["result"];
            $listSolution = $exercise->getSolutions();
            $nombre = count($listSolution);
            for ($j = 0; $j < count($compare); $j++) {
                $reponse[$compare[$j]] = 0;
                $egal = 0;

                for ($i = 0; $i < $nombre; $i++) {
                    $tab = $listSolution[$i]->getSolutionArray();
                    if ($j < count($tab) && $compare[$j] == $tab[$j]) {
                        $reponse[$compare[$j]] = 1;
                    }
                    if ($tab == $compare) {
                        $egal = 1;
                    }
                }
            }
            if ($egal == 1) {
                
                $listExercise->setNomberTry($data["cp"])
                ->setExercise($exercise)
                ->setTry(true)
                    ->setStatus(true);
                $manager->persist($listExercise);
                $manager->flush();

             
            }else{
                $listExercise->setNomberTry($data["cp"])
                    ->setExercise($exercise)
                    ->setTry(true)
                    ->setStatus(false);
                $manager->persist($listExercise);
                $manager->flush();

            }




            $json["tab"] = $reponse;
            $json["status"] = $egal;








            return $this->json($json, 200);
        }
    }
}
