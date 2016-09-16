<?php
/**
 * Created by PhpStorm.
 * User: koen
 * Date: 16-9-16
 * Time: 14:14
 */

namespace AppBundle\Helper;



use AppBundle\Entity\Entry;

interface ScoringInterface
{

    public function score(Entry $entry): int;

}