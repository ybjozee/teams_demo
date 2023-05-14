<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:setup:complete',
    description: 'Complete project setup',
)]
class CompleteSetupCommand extends Command {

    protected function configure()
    : void {

        $this->setHelp(
            'This command helps you complete the initial set up for the application.
            With your permission, it will seed the database with a demo user, two new teams and some players'
        );
    }

    /**
     * @throws ExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    : int {

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion(
            <<<EOT

<info>Would you like to include seed data - team and players? (yes/no) <comment>[y]</comment>:</info>
EOT
        );

        $loadFixturesCommand = $this->getApplication()->find('doctrine:fixtures:load');
        $arguments = [];

        if (!$helper->ask($input, $output, $question)) {
            $arguments['--group'] = ['CountryFixtures','UserFixtures'];
        }

        $loadFixturesInput = new ArrayInput($arguments);
        $loadFixturesInput->setInteractive(false);

        $returnCode = $loadFixturesCommand->run($loadFixturesInput, $output);

        if ($returnCode === Command::SUCCESS) {
            $io = new SymfonyStyle($input, $output);
            $io->success('Setup completed successfully');
        }

        return $returnCode;
    }
}
