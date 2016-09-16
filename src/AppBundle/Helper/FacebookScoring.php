<?php
/**
 * Created by PhpStorm.
 * User: koen
 * Date: 16-9-16
 * Time: 14:24
 */

namespace AppBundle\Helper;


use AppBundle\Entity\Entry;

class FacebookScoring implements ScoringInterface
{

    public function score(Entry $entry): int
    {
        return 0;
    }
}