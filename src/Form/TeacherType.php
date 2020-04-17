<?php

namespace App\Form;

use App\Entity\Teacher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class TeacherType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration("Nom", "Tapez votre nom"))
            ->add('lastName', TextType::class, $this->getConfiguration("Prénom", "Tapez votre prénom"))
            ->add('email', TextType::class, $this->getConfiguration("Email", "Tapez votre email"))
            ->add('hash', PasswordType::class, $this->getConfiguration("Mot de passe", "Tapez votre mot de passe"))
            ->add('confirm', PasswordType::class, $this->getConfiguration("Confirmer mot de passe", "Confirmer votre mot de passe"));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
        ]);
    }
}
