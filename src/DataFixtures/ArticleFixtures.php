<?php

namespace App\DataFixtures;

use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for($i = 1;$i<=10;$i++ ){
            $article=new Article();
            $article->setTitle("titre de l'article n°$i")
                    ->setContent("<p>contenu de l'article n°$i</p>")
                    ->setImage("http://placehold.it/350*150")
                    ->setCreatedAt(new DateTime());
            $manager->persist($article);#préparation pour mettre en place dans la BD
        }


        $manager->flush(); #balancer maintenant dans la BD
    }
}
