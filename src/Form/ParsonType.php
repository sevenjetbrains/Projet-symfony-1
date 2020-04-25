<?php

namespace App\Form;

use App\Entity\Classes;
use App\Form\LinesType;
use App\Entity\Exercise;

use App\Form\ApplicationType;

use App\Repository\ClassesRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ParsonType extends ApplicationType
{
    private $security;
    private $repository;
    private $result;

    public function __construct(Security $security, ClassesRepository $repository)
    {
        $this->security = $security;
        $this->repository = $repository;
        $this->result = $this->repository->findByExampleField($this->security->getUser());
        //dd($this->result);
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {





        $builder
            ->add('classes', EntityType::class, [
                'class' => Classes::class,
                'choices' => $this->result,
                'choice_label' => 'title',
                'label' => 'cours'



            ])
        ->add('title',TextType::class,$this->getConfiguration("titre","un titre pour l'exercice"))
        ->add('description',TextareaType::class,$this->getConfiguration("description", "rédigez l'énonce de l'exercice"))
         ->add('linesExercise',CollectionType::class,[
             'label'=> 'instruction',
             'entry_type' => LinesType::class,
            'allow_add' => true,
         ])   
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Exercise::class,
        ]);
    }
}
