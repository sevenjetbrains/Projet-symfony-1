<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\Exercise;
use App\Form\ApplicationType;
use App\Repository\ClassesRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ExerciseType extends ApplicationType
{
private $security;
private $repository;
private $result;

public function __construct(Security $security, ClassesRepository $repository){
        $this->security = $security;
       $this->repository=$repository;
    $this->result= $this->repository->findByExampleField($this->security->getUser());
    //dd($this->result);
}
public function classe(){

}

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('classes',EntityType::class,[
            'class' => Classes::class,
            'choices'=>$this->result,
            'choice_label' => 'title',
            'label' =>'cours'
            
                
            
        ])
        ->add('title', TextType::class, $this->getConfiguration("Titre", "Titre d'exercice"))
            
        
            ->add('description', CKEditorType::class, ['config_name' => 'my_config', 'label' => "contenu"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Exercise::class,
        ]);
    }
}
