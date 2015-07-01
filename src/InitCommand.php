<?php

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends Command
{

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('init')
            ->setDescription('Initialize environment variables required to run command');
    }

    /**
     * Execute the command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface   $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (is_dir(jira_home_path())) {
            throw new \InvalidArgumentException("jira-cli has already been initialized.");
        }

        mkdir(jira_home_path());

        copy(__DIR__ . '/../.env.example', jira_home_path() . '/.env');

        $output->writeln('<comment>Creating .env file...</comment> <info>✔</info>');
        $output->writeln('<comment>.env file created at:</comment> ' . jira_home_path() . '/.env, please fill out required information');
    }

}
