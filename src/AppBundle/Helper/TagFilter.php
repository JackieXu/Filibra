<?php
namespace AppBundle\Helper;

use AppBundle\Entity\Challenge;

class InstagramTagFilter
{

    // tag to filter entries on
    private $tag;

    public function __construct(Challenge $challenge)
    {
        $this->tag = $challenge->getHashTag();
    }

    public function filter($entry)
    {
        return in_array($this->tag, $entry['tags']);
    }

}