<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;

/**
 * Class Entry
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\EntryRepository")
 * @ORM\Table(name="entries",uniqueConstraints={@UniqueConstraint(name="unique_entry", columns={"challenge_id", "media_url"})})
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
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var User
     */
    protected $user;

    /**
     * Challenge this entry is submitted to
     *
     * @ORM\ManyToOne(targetEntity="Challenge", inversedBy="entries")
     * @ORM\JoinColumn(name="challenge_id", referencedColumnName="id")
     *
     * @var Challenge
     */
    protected $challenge;

    /**
     * URL to entry uploaded to instagram/facebook
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $media_url;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $likes;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $comments;

    /**
     * Get id
     *
     * @return integer
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
     * @return integer
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Set challenge
     *
     * @param \AppBundle\Entity\Challenge $challenge
     *
     * @return Entry
     */
    public function setChallenge(\AppBundle\Entity\Challenge $challenge = null)
    {
        $this->challenge = $challenge;

        return $this;
    }

    /**
     * Get challenge
     *
     * @return \AppBundle\Entity\Challenge
     */
    public function getChallenge()
    {
        return $this->challenge;
    }

    /**
     * Set comments
     *
     * @param integer $comments
     *
     * @return Entry
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return integer
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Entry
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set mediaUrl
     *
     * @param string $mediaUrl
     *
     * @return Entry
     */
    public function setMediaUrl($mediaUrl)
    {
        $this->media_url = $mediaUrl;

        return $this;
    }

    /**
     * Get mediaUrl
     *
     * @return string
     */
    public function getMediaUrl()
    {
        return $this->media_url;
    }
}
