<?php


namespace AppBundle\Service;


use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Facebook\Authentication\AccessToken;
use Facebook\GraphNodes\GraphUser;

/**
 * Class UserService
 *
 * @package AppBundle\Service
 */
class UserService
{
    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * @var \AppBundle\Entity\Repository\UserRepository
     */
    protected $userRepository;

    /**
     * UserService constructor.
     *
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $entityManager->getRepository('AppBundle:User');
    }

    /**
     * Log in with Facebook.
     *
     * @param AccessToken $accessToken
     * @param GraphUser $graphUser
     * @return User|null
     */
    public function loginWithFacebook(AccessToken $accessToken, GraphUser $graphUser)
    {
        $user = $this->userRepository->findOneBy([
            'facebookId' => $graphUser->getId()
        ]);

        if ($user) {
            return $user;
        }

        $user = new User();
        $user->setName($graphUser->getName());
        $user->setAvatarURL($graphUser->getPicture()->getUrl());
        $user->setFacebookId($graphUser->getId());
        $user->setFacebookAccessToken($accessToken->getValue());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }


    /**
     * Log in with Instagram.
     *
     * @param array $instagramData
     * @return User
     */
    public function loginWithInstagram(array $instagramData)
    {
        $user = $this->userRepository->findOneBy([
            'instagramId' => $instagramData['user']['id']
        ]);

        if ($user) {
            return $user;
        }

        $user = new User();
        $user->setName($instagramData['user']['full_name']);
        $user->setAvatarURL($instagramData['user']['profile_picture']);
        $user->setWebsiteURL($instagramData['user']['website']);
        $user->setInstagramId($instagramData['user']['id']);
        $user->setInstagramUsername($instagramData['user']['username']);
        $user->setInstagramAccessToken($instagramData['access_token']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}