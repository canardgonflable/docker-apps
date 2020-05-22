<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Faker\Factory;

/**
 * Class PropertyFixture
 * @package App\DataFixtures
 *
 * @author  Clément Magnin <cma.asdoria@gmail.com>
 */
class PropertyFixture extends Fixture
{
    /**
     * @param ObjectManager $manager
     *
     * @throws Exception
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr');
        for ($i = 0; $i < 100; $i++) {
            $property = new Property();
            $property
                ->setTitle($faker->words(3, true))
                ->setDescription($faker->sentences(3, true))
                ->setSurface($faker->numberBetween(10, 400))
                ->setRooms($faker->numberBetween(2, 10))
                ->setBedrooms($faker->numberBetween(0, 15))
                ->setFloor($faker->numberBetween(0, 15))
                ->setPrice($faker->numberBetween(100000, 2000000))
                ->setHeat($faker->numberBetween(0, count(Property::HEAT) - 1))
                ->setCity($faker->city)
                ->setAddress($faker->city)
                ->setPostalCode($faker->postcode)
                ->setSold(false);
            $manager->persist($property);

        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
