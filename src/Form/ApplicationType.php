<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;



class ApplicationType extends AbstractType
{


    /**
     * Permet de configurer un champ
     *
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    public function getConfiguration($label, $placeholder, $option = [])
    {
        return array_merge_recursive(
            [
                'label' => $label,
                'attr' => [
                    'placeholder' => $placeholder
                ]
            ],
            $option
        );
    }
}
