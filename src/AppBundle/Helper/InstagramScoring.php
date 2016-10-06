<?php
/**
 * Created by PhpStorm.
 * User: koen
 * Date: 16-9-16
 * Time: 14:16
 */

namespace AppBundle\Helper;


use AppBundle\Entity\Entry;

class InstagramScoring implements ScoringInterface
{

    public function score(Entry $entry): int
    {
        // weigh comments 10 times as heavy as likes
        return $entry->getLikes() + $entry->getComments() * 10;
    }
}
