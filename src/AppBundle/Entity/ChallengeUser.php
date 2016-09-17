<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ChallengeUser
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ChallengeRepository")
 * @ORM\Table(name="user_challenges")
 *
 * @package AppBundle\Entity
 */
class ChallengeUser
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Challenge", inversedBy="participants")
     * @ORM\JoinColumn(name="challenge_id", referencedColumnName="id", nullable=false)
     */
    protected $challenge;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User", inversedBy="challenges")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    /**
     * @ORM\Column(type="integer", options={"default":0})
     *
     * @var integer
     */
    protected $score;

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return ChallengeUser
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set challenge
     *
     * @param \AppBundle\Entity\Challenge $challenge
     *
     * @return ChallengeUser
     */
    public function setChallenge(\AppBundle\Entity\Challenge $challenge)
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return ChallengeUser
     */
    public function setUser(\AppBundle\Entity\User $user)
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
}
