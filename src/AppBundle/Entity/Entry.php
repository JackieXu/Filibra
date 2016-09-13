<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Entry
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\EntryRepository")
 * @ORM\Table(name="entries")
 *
 * @package AppBundle\Entity
 */
class Entry
{
    /**
     * Entry identifier.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $likes;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set likes
     *
     * @param integer $likes
     *
     * @return Entry
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return int
     */
    public function getLikes()
    {
        return $this->likes;
    }
}

