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
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $avatarURL;

    /**
     * User website URL.
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $websiteURL;

    /**
     * User Instagram identifier.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    protected $instagramId;

    /**
     * User Instagram username.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    protected $instagramUsername;

    /**
     * User Instagram access token.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    protected $instagramAccessToken;

    /**
     * User Facebook identifier.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    protected $facebookId;

    /**
     * User Facebook access token.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    protected $facebookAccessToken;

    /**
     * Challenges the user is or has participated in.
     *
     * @ORM\OneToMany(targetEntity="ChallengeUser", mappedBy="user")
     *
     * @var ArrayCollection
     */
    protected $challenges;

    /**
     * User roles
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $roles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->challenges = new ArrayCollection();
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
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set facebookAccessToken
     *
     * @param string $facebookAccessToken
     *
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebookAccessToken = $facebookAccessToken;

        return $this;
    }

    /**
     * Get facebookAccessToken
     *
     * @return string
     */
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
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
     * Sets user roles.
     *
     * @param string $roles A comma delimited string of user roles.
     * @return User
     */
    public function setRoles(string $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     * @return string[] The user roles
     */
    public function getRoles()
    {
        return explode(',', $this->roles);
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
