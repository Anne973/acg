<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 23/04/2018
 * Time: 16:37
 */
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 3 articles
        for ($i = 0; $i < 4; $i++) {
            $article = new Article();
            $article->setTitle('article ' . $i);
            $article->setContent('Hae duae provinciae bello quondam piratico catervis mixtae praedonum a Servilio pro consule missae sub iugum factae sunt vectigales. et hae quidem regiones velut in prominenti terrarum lingua positae ob orbe eoo monte Amano disparantur.');
            $manager->persist($article);
        }



        $manager->flush();
    }
}
