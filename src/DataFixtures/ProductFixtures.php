<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\ORM\Doctrine\Populator;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $generator = \Faker\Factory::create();
        $populator = new Populator($generator, $manager);
        $populator->addEntity(Category::class, 10);
        $populator->addEntity(Product::class, 150, [
            "price" => function() use ($generator) {
                return $generator->randomFloat(2, 0, 99999999.99);
            },
            "imageName" => function() { return 'mac.jpg'; }
        ]);
        $populator->execute();

        $manager->flush();
    }
}
