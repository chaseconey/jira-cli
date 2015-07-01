<?php

namespace App;

use chobie\Jira\Api;
use chobie\Jira\Api\Authentication\Basic;
use chobie\Jira\Issues\Walker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SearchCommand extends Command
{

    public function configure()
    {
        $this->setName('search')
            ->setDescription('Search for an issue in Jira')
            ->addArgument('search', InputArgument::REQUIRED, 'Search term');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $api = new Api(
            getenv('JIRA_URL'),
            new Basic(getenv('JIRA_USERNAME'), getenv('JIRA_PASSWORD'))
        );

        $search = $input->getArgument('search');

        $walker = new Walker($api);
        $walker->push("text ~ '{$search}' ORDER BY status ASC");

        $rows = $this->buildRows($walker);

        $table = new Table($output);
        $table->setHeaders(['Key', 'Summary', 'Status', 'Link'])
            ->setRows($rows)
            ->render();
    }

    /**
     * Iterate through issues and build array for table structure
     *
     * @param $walker
     *
     * @return array
     */
    private function buildRows($walker)
    {
        $rows = [];
        foreach ($walker as $issue) {
            $rows[] = $this->buildRow($issue);
        }

        return $rows;
    }

    /**
     * Format individual row for table structure
     *
     * @param $issue
     *
     * @return array
     */
    private function buildRow($issue)
    {
        return [
            "<info>{$issue->getKey()}</info>",
            $issue->getSummary(),
            $issue->getStatus()['name'],
            getenv('JIRA_URL') . '/browse/' . $issue->getKey()
        ];
    }

}
