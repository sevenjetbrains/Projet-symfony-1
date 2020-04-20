<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Classes;
use App\Entity\Teacher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $teachers=[];
        $faker =Factory::create('fr_FR');
        
        for($i=0;$i<5;$i++){
            $teacher=new Teacher();
            $teacher->setFirstName($faker->firstName())
            ->setLastName($faker->lastName())
            ->setEmail($faker->freeEmail())
            ->setHash($this->encoder->encodePassword($teacher,"password"));
            $manager->persist($teacher);
            $teachers[]=$teacher;
            
        }
        //----------creation de cours
        for($i=0;$i<5;$i++){
            $classe=new Classes();
            
            $title= $faker->words($nb = 3, $asText = true);
            $classe->setTitle($title)
            ->setAuthor($teachers[1])
            ->setContent('<p>' . join('<p></p>', $faker->paragraphs(6)) . '</p>');
            
            $manager->persist($classe);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
