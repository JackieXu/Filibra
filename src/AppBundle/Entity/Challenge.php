<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Challenge
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ChallengeRepository")
 * @ORM\Table(name="challenges")
 *
 * @package AppBundle\Entity
 */
class Challenge
{
    /**
     * Challenge identifier.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * Challenge name.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $name;

    /**
     * URL Slug
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $slug;

    /**
     * Challenge prize money.
     *
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $prize;

    /**
     * Challenge hash tag.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $hashTag;

    /**
     * Challenge start date and time.
     *
     * @ORM\Column(type="datetime", name="start_date")
     *
     * @var \DateTime
     */
    protected $startDate;

    /**
     * Challenge finish date and time.
     *
     * @ORM\Column(type="datetime", name="finish_date")
     *
     * @var \DateTime
     */
    protected $finishDate;

    /**
     * Challenge sponsor name.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $sponsorName;

    /**
     * Challenge sponsor image URL.
     *
     * @ORM\Column(type="text")
     *
     * @var string
     */
    protected $sponsorImageURL;

    /**
     * Challenge sponsor website URL.
     *
     * @ORM\Column(type="text")
     *
     * @var string
     */
    protected $sponsorWebsiteURL;

    /**
     * Users participating in challenge.
     *
     * @ORM\OneToMany(targetEntity="ChallengeUser", mappedBy="challenge")
     *
     * @var ArrayCollection
     */
    protected $participants;

    /**
     * Entries for this challenge
     *
     * @ORM\OneToMany(targetEntity="Entry", mappedBy="challenge")
     *
     * @var ArrayCollection
     */
    protected $entries;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->entries = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Challenge
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set prize
     *
     * @param integer $prize
     *
     * @return Challenge
     */
    public function setPrize($prize)
    {
        $this->prize = $prize;

        return $this;
    }

    /**
     * Get prize
     *
     * @return integer
     */
    public function getPrize()
    {
        return $this->prize;
    }

    /**
     * Set hashTag
     *
     * @param string $hashTag
     *
     * @return Challenge
     */
    public function setHashTag($hashTag)
    {
        $this->hashTag = $hashTag;

        return $this;
    }

    /**
     * Get hashTag
     *
     * @return string
     */
    public function getHashTag()
    {
        return $this->hashTag;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Challenge
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set finishDate
     *
     * @param \DateTime $finishDate
     *
     * @return Challenge
     */
    public function setFinishDate($finishDate)
    {
        $this->finishDate = $finishDate;

        return $this;
    }

    /**
     * Get finishDate
     *
     * @return \DateTime
     */
    public function getFinishDate()
    {
        return $this->finishDate;
    }

    /**
     * Set sponsorName
     *
     * @param string $sponsorName
     *
     * @return Challenge
     */
    public function setSponsorName($sponsorName)
    {
        $this->sponsorName = $sponsorName;

        return $this;
    }

    /**
     * Get sponsorName
     *
     * @return string
     */
    public function getSponsorName()
    {
        return $this->sponsorName;
    }

    /**
     * Set sponsorImageURL
     *
     * @param string $sponsorImageURL
     *
     * @return Challenge
     */
    public function setSponsorImageURL($sponsorImageURL)
    {
        $this->sponsorImageURL = $sponsorImageURL;

        return $this;
    }

    /**
     * Get sponsorImageURL
     *
     * @return string
     */
    public function getSponsorImageURL()
    {
        return $this->sponsorImageURL;
    }

    /**
     * Set sponsorWebsiteURL
     *
     * @param string $sponsorWebsiteURL
     *
     * @return Challenge
     */
    public function setSponsorWebsiteURL($sponsorWebsiteURL)
    {
        $this->sponsorWebsiteURL = $sponsorWebsiteURL;

        return $this;
    }

    /**
     * Get sponsorWebsiteURL
     *
     * @return string
     */
    public function getSponsorWebsiteURL()
    {
        return $this->sponsorWebsiteURL;
    }

    /**
     * Add entry
     *
     * @param Entry $entry
     *
     * @return Challenge
     */
    public function addEntry(Entry $entry)
    {
        $this->entries[] = $entry;

        return $this;
    }

    /**
     * Remove entry
     *
     * @param Entry $entry
     */
    public function removeEntry(Entry $entry)
    {
        $this->entries->removeElement($entry);
    }

    /**
     * Get entries
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Challenge
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add participant
     *
     * @param ChallengeUser $participant
     *
     * @return Challenge
     */
    public function addParticipant(ChallengeUser $participant)
    {
        $this->participants[] = $participant;

        return $this;
    }

    /**
     * Remove participant
     *
     * @param ChallengeUser $participant
     */
    public function removeParticipant(ChallengeUser $participant)
    {
        $this->participants->removeElement($participant);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipants()
    {
        return $this->participants;
    }
}
