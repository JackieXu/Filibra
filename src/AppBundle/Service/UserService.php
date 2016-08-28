<?php


namespace AppBundle\Service;


use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

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
     * Login with Instagram.
     *
     * @param array $instagramData
     * @return User
     */
    public function loginWithInstragram(array $instagramData)
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