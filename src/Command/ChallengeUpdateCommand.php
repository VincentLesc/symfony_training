<?php

namespace App\Command;

use App\Repository\Challenge\ChallengeRepository;
use App\Service\Challenge\ChallengeStateService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ChallengeUpdateCommand extends Command
{
    protected static $defaultName = 'app:challenge:update';
    protected static $defaultDescription = 'Add a short description for your command';

    private ChallengeStateService $service;
    private ChallengeRepository $challengeRepository;
    private EntityManagerInterface $em;

    public function __construct(ChallengeStateService $service, ChallengeRepository $challengeRepository, EntityManagerInterface $em)
    {
        parent::__construct();
        $this->service = $service;
        $this->challengeRepository = $challengeRepository;
        $this->em = $em;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        $challenges  = $this->challengeRepository->findAll();

        $io->note(sprintf('%d lines will be threated', count($challenges)));

        foreach ($challenges as $challenge) {
            $this->service->updateState($challenge);
        }

        $this->em->flush();

        return Command::SUCCESS;
    }
}
