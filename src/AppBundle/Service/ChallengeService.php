<?php


namespace AppBundle\Service;
use AppBundle\Entity\Challenge;
use AppBundle\Entity\ChallengeUser;
use AppBundle\Entity\Repository\ChallengeRepository;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;

/**
 * Class ChallengeService
 *
 * @package AppBundle\Service
 */
class ChallengeService
{
    /**
     * Doctrine entity manager
     *
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Challenge repository
     *
     * @var ChallengeRepository
     */
    protected $challengeRepository;

    /**
     *
     * @var ObjectRepository
     */
    protected $challengeParticipantsRepository;

    /**
     * ChallengeService constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->challengeRepository = $this->entityManager->getRepository('AppBundle:Challenge');
        $this->challengeParticipantsRepository = $this->entityManager->getRepository('AppBundle:ChallengeUser');
    }

    /**
     * Checks whether user is participating in the challenge.
     *
     * @param User $user
     * @param Challenge $challenge
     * @return bool True if user is participating in the challenge.
     */
    public function isUserInChallenge(User $user, Challenge $challenge)
    {
        return !is_null($this->challengeParticipantsRepository->findOneBy([
            'user' => $user,
            'challenge' => $challenge
        ]));
    }
}