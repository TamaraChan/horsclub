<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getDataFixture() as $row) {
            $service = (new Service())->setName($row['name']);
            $manager->persist($service);
        }

        $manager->flush();
    }

    protected function getDataFixture()
    {
        return [
            [
                'name' => 'ШАГОВАЯ ПРОГУЛКА'
            ],
            [
                'name' => 'АКТИВНАЯ ПРОГУЛКА'
            ],
            [
                'name' => 'ТРЕНИРОВКА'
            ],
            [
                'name' => 'АБОНЕМЕНТЫ'
            ],
            [
                'name' => 'ПОСТОЙ ЛОШАДИ'
            ],
            [
                'name' => 'УЧАСТИЕ ЛОШАДИ В ФОТОСЕССИЯХ'
            ],
            [
                'name' => 'КУПАНИЕ С ЛОШАДЬЮ'
            ]
        ];
    }
}
