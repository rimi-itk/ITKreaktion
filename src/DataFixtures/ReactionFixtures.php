<?php

namespace App\DataFixtures;

use App\Entity\Reaction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReactionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach (['clap', 'laugh', 'aww', 'boo'] as $id) {
            $reaction = (new Reaction())->setId($id);
            $this->addReference('reaction:' . $id, $reaction);
            $manager->persist($reaction);
        }

        $manager->flush();
    }
}
