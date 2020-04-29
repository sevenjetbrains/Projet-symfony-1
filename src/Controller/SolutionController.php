<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Entity\Solution;
use Symfony\Flex\Unpack\Result;
use App\Repository\LinesRepository;
use App\Repository\ExerciseRepository;
use App\Repository\SolutionRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SolutionController extends AbstractController
{
    /**
     * @Route("/teacher/solution/exercice/{id}", name="solution_show")
     */
    public function index(Exercise $exercise,LinesRepository $line)
    {
        $final=[];
        $result=[];
     $tab=$exercise->getSolutions();
    // dd($tab[0]->getSolutionArray());
     for($i=0;$i<count($tab);$i++){
       $sol= $tab[$i]->getSolutionArray();
       for($j=0;$j<count($sol);$j++){
           $result[$j]=($line->find($sol[$j]))->getInstruction();
       }
    
            $final[$i]=$result;
    }
//dd($final);
return $this->render("exercise_teacher/listSolution.html.twig",[
    "colSolution"=>$tab,
    "exercise"=>$exercise,
     "finals"=>$final,
]);



     }
    /**
     * * @Route("/teacher/solution/supprimer/{id1}/{id2}", name="solution_remove")
     *  @Entity("Solution", expr="SolutionRepository.find(id1)")
     */

public function solutionRemove($id1,$id2, ObjectManager $manager,SolutionRepository $solution){
   $result=$solution->find($id1);
   $manager->remove($result);
   $this->addFlash("success text-center","la solution est supprimer");
   $manager->flush();

return $this->redirectToRoute("solution_show",["id"=>$id2]);
}
     
}
