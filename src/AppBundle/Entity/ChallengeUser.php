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

    public function __construct()
    {
        $this->score = 0;
    }

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
     * @param Challenge $challenge
     *
     * @return ChallengeUser
     */
    public function setChallenge(Challenge $challenge)
    {
        $this->challenge = $challenge;

        return $this;
    }

    /**
     * Get challenge
     *
     * @return Challenge
     */
    public function getChallenge()
    {
        return $this->challenge;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return ChallengeUser
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
