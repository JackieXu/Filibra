<?php
namespace AppBundle\Helper;

use AppBundle\Entity\Challenge;

class TagFilter
{

    // tag to filter entries on
    private $tag;

    public function __construct(Challenge $challenge)
    {
        $this->tag = $challenge->getHashTag();
    }

    /**
     * Tag filter for Instagram entries
     *
     * @param $entry
     * @return bool
     */
    public function instagramFilter($entry)
    {
        return in_array($this->tag, $entry['tags']);
    }

    /**
     * Tag filter for Facebook entries
     * @param $entry
     * @return bool
     */
    public function facebookFilter($entry)
    {
        return true;
    }

}