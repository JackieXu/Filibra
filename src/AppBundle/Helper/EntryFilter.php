<?php
namespace AppBundle\Helper;

use AppBundle\Entity\Challenge;

class EntryFilter
{

    // tag to filter entries on
    private $tag;

    // filter entries outside date range
    private $startDate;
    private $endDate;

    public function __construct(Challenge $challenge)
    {
        $this->tag = $challenge->getHashTag();
        $this->startDate = $challenge->getStartDate()->getTimestamp();
        $this->endDate = $challenge->getFinishDate()->getTimestamp();
    }

    /**
     * Tag filter for Instagram entries
     *
     * @param $entry -JSON entry
     * @return bool
     */
    public function instagramFilter($entry)
    {
        $created = (int)$entry['created_time'];

        # check hashtag
        $valid = in_array($this->tag, $entry['tags']);
        # check date
        $valid &= $created >= $this->startDate && $created <= $this->endDate;

        return $valid;
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