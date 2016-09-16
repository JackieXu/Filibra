<?php
namespace AppBundle\Command;

use AppBundle\Entity\Challenge;
use AppBundle\Entity\Entry;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateChallengesCommand extends ContainerAwareCommand
{

    /**
     * @var OutputInterface
     */
    private $output;

    private $instagramService;

    private $entityManager;

    protected function configure()
    {
        $this->setName('app:update-challenges')
            ->setDescription('Update media for every participant in every challenge.')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->instagramService = $this->getContainer()->get('instagram.service');
        $this->entityManager = $this->getContainer()->get('doctrine')->getEntityManager();

        $this->output->writeln("Updating active challenges...");

        $challengeRepository = $this->getContainer()->get('doctrine')->getManager()->getRepository('AppBundle:Challenge');
        $challenges = $challengeRepository->findAll();

        $progress = new ProgressBar($this->output, count($challenges));
        foreach ($challenges as $challenge) {
            $this->updateChallenge($challenge);
            $progress->advance();
        }
    }

    private function updateChallenge(Challenge $challenge)
    {
        $this->output->writeln("Updating challenge " . $challenge->getName());

        foreach ($challenge->getUsers() as $participant) {
            $entries = $this->instagramService->getUserEntriesForChallenge($participant, $challenge);

            foreach ($entries as $e){
                $this->entityManager->persist($e);
            }

            $this->output->writeln(sprintf("%d items for user %s in challenge %s.", count($entries),
                $participant->getName(), $challenge->getName()));
        }

        $this->entityManager->flush();

    }
}
