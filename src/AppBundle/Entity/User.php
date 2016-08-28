<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserRepository")
 * @ORM\Table(name="users")
 *
 * @package AppBundle\Entity
 */
class User implements UserInterface
{
    /**
     * User identifier.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * User full name.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $name;

    /**
     * User avatar URL.
     *
     * @ORM\Column(type="text")
     *
     * @var string
     */
    protected $avatarURL;

    /**
     * User website URL.
     *
     * @ORM\Column(type="text")
     *
     * @var string
     */
    protected $websiteURL;

    /**
     * User Instagram identifier.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $instagramId;

    /**
     * User Instagram username.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $instagramUsername;

    /**
     * User Instagram access token.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $instagramAccessToken;

    /**
     * Challenges the user is or has participated in.
     *
     * @ORM\ManyToMany(targetEntity="Challenge", inversedBy="users")
     * @ORM\JoinTable(name="user_challenges")
     *
     * @var ArrayCollection
     */
    protected $challenges;

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
     * @return User
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
     * Set avatarURL
     *
     * @param string $avatarURL
     *
     * @return User
     */
    public function setAvatarURL($avatarURL)
    {
        $this->avatarURL = $avatarURL;

        return $this;
    }

    /**
     * Get avatarURL
     *
     * @return string
     */
    public function getAvatarURL()
    {
        return $this->avatarURL;
    }

    /**
     * Set websiteURL
     *
     * @param string $websiteURL
     *
     * @return User
     */
    public function setWebsiteURL($websiteURL)
    {
        $this->websiteURL = $websiteURL;

        return $this;
    }

    /**
     * Get websiteURL
     *
     * @return string
     */
    public function getWebsiteURL()
    {
        return $this->websiteURL;
    }

    /**
     * Set instagramId
     *
     * @param integer $instagramId
     *
     * @return User
     */
    public function setInstagramId($instagramId)
    {
        $this->instagramId = $instagramId;

        return $this;
    }

    /**
     * Get instagramId
     *
     * @return integer
     */
    public function getInstagramId()
    {
        return $this->instagramId;
    }

    /**
     * Set instagramUsername
     *
     * @param string $instagramUsername
     *
     * @return User
     */
    public function setInstagramUsername($instagramUsername)
    {
        $this->instagramUsername = $instagramUsername;

        return $this;
    }

    /**
     * Get instagramUsername
     *
     * @return string
     */
    public function getInstagramUsername()
    {
        return $this->instagramUsername;
    }

    /**
     * Set instagramAccessToken
     *
     * @param string $instagramAccessToken
     *
     * @return User
     */
    public function setInstagramAccessToken($instagramAccessToken)
    {
        $this->instagramAccessToken = $instagramAccessToken;

        return $this;
    }

    /**
     * Get instagramAccessToken
     *
     * @return string
     */
    public function getInstagramAccessToken()
    {
        return $this->instagramAccessToken;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->challenges = new ArrayCollection();
    }

    /**
     * Add challenge
     *
     * @param Challenge $challenge
     *
     * @return User
     */
    public function addChallenge(Challenge $challenge)
    {
        $this->challenges[] = $challenge;

        return $this;
    }

    /**
     * Remove challenge
     *
     * @param Challenge $challenge
     */
    public function removeChallenge(Challenge $challenge)
    {
        $this->challenges->removeElement($challenge);
    }

    /**
     * Get challenges
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChallenges()
    {
        return $this->challenges;
    }

    /**
     * Returns the roles granted to the user.
     *
     * @return string[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return 'filibra';
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->instagramUsername;
    }

    /**
     * Removes sensitive data from the user.
     *
     * TODO: Implement this.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        return $this;
    }
}
