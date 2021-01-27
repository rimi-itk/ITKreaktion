<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $event = (new Event())
            ->setCode('123456')
            ->setTitle('Test event')
            ->setDescription('This is a test')
            ->addReaction($this->getReference('reaction:clap'))
            ->addReaction($this->getReference('reaction:laugh'))
            ->addReaction($this->getReference('reaction:aww'))
            ->addReaction($this->getReference('reaction:boo'));
        $manager->persist($event);

        $event = (new Event())
            ->setCode('230575')
            ->setTitle('Another test event')
            ->setDescription('This is another test')
            ->addReaction($this->getReference('reaction:clap'));
        $manager->persist($event);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ReactionFixtures::class];
    }
}
