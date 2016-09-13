<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:update-challenges')
            ->setDescription('Update media for every participant in every challenge.')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $instagramService = $this->getContainer()->get('instagram.service');

        $challengeRepository = $this->getContainer()->get('doctrine')->getManager()->getRepository('AppBundle:Challenge');
        $challenges = $challengeRepository->findAllActiveChallenges();

        foreach ($challenges as $challenge){
            foreach ($challenge->getUsers() as $participant)
            {
                $instagramService->updateUserMediaForChallenge($participant, $challenge);
                $output->write("Updating for " + $participant->getName());
            }
        }
    }
}
