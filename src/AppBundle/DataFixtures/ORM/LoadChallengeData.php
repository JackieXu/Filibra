<?php

namespace AppBundle\DataFixtures\ORM;

use DateTime;
use DateInterval;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Challenge;

class LoadChallengeData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cocaCola = new Challenge();
        $cocaCola
            ->setName('Coca Cola Challenge')
            ->setHashTag('#cocaColaChallenge')
            ->setSlug('coca-cola-challenge')
            ->setPrize(10000)
            ->setStartDate(new DateTime())
            ->setFinishDate(date_add(new DateTime(), new DateInterval('P10D')))
            ->setSponsorName('Coca Cola')
            ->setSponsorImageURL('http://vignette4.wikia.nocookie.net/logopedia/images/5/59/Coca-Cola_logo_2007.jpg/revision/latest?cb=20150801090518')
            ->setSponsorWebsiteURL('http://www.cocacola.com');

        $manager->persist($cocaCola);

        $mcDonalds = new Challenge();
        $mcDonalds
            ->setName('McDonalds Challenge')
            ->setHashTag('#mcDonaldsChallenge')
            ->setSlug('mc-donalds-challenge')
            ->setPrize(4500)
            ->setStartDate(date_add(new DateTime(), new DateInterval('P4D')))
            ->setFinishDate(date_add(new DateTime(), new DateInterval('P9D')))
            ->setSponsorName('Mc Donalds')
            ->setSponsorImageURL('http://vignette4.wikia.nocookie.net/logopedia/images/5/59/Coca-Cola_logo_2007.jpg/revision/latest?cb=20150801090518')
            ->setSponsorWebsiteURL('https://www.google.nl/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&cad=rja&uact=8&ved=0ahUKEwjt2NyNobjQAhXDPRoKHWWhAu4QjRwIBw&url=https%3A%2F%2Fwww.mcdonalds.com.sg%2F&bvm=bv.139250283,d.d2s&psig=AFQjCNE_wV8ZsNpaqO3foJ5lKxn1uqQdog&ust=1479763043905224');

        $manager->persist($mcDonalds);

        $starbucks = new Challenge();
        $starbucks
            ->setName('Starbucks Challenge')
            ->setHashTag('#starbucksChallenge')
            ->setSlug('starbucks-challenge')
            ->setPrize(12500)
            ->setStartDate(date_sub(new DateTime(), new DateInterval('P3D')))
            ->setFinishDate(date_add(new DateTime(), new DateInterval('PT8H')))
            ->setSponsorName('Starbucks')
            ->setSponsorImageURL('https://upload.wikimedia.org/wikipedia/en/thumb/3/35/Starbucks_Coffee_Logo.svg/1024px-Starbucks_Coffee_Logo.svg.png')
            ->setSponsorWebsiteURL('http://www.starbucks.com');

        $manager->persist($starbucks);

        $manager->flush();
    }
}
