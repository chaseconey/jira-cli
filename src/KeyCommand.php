<?php

namespace App;

use chobie\Jira\Api;
use chobie\Jira\Issue;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class KeyCommand extends JiraCommand
{

    public function configure()
    {
        $this->setName('key')
            ->setDescription('Get detailed information about a specific issue by issue key')
            ->addArgument('key', InputArgument::REQUIRED, 'Jira key (Ex: PROJ-1)')
            ->addOption('comments', 'c', InputOption::VALUE_NONE, 'Display comments');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $api = $this->getApi();

        $key = $input->getArgument('key');
        $showComments = $input->getOption('comments');

        $result = $api->getIssue($key);
        $issue = new Issue($result->getResult());

        $lines = $this->output($issue, $showComments);

        $output->writeln($lines);
    }

    /**
     * Formulate all data and text needed for output
     *
     * @param $issue
     * @param $showComments
     *
     * @return array
     */
    protected function output($issue, $showComments)
    {
        $lines = [];
        $lines[] = $this->getHeader($issue);
        $lines[] = getenv('JIRA_URL') . '/browse/' . $issue->getKey();
        $lines[] = "<info>{$issue->get('assignee')['displayName']}</info>";
        $lines[] = "{$issue->get('description')}";

        if ($showComments) {
            $lines = array_merge($lines, $this->printComments($issue));
        }

        $lines[] = '';

        return $lines;
    }

    /**
     * Format header string
     *
     * @param $issue
     *
     * @return string
     */
    protected function getHeader($issue)
    {
        $header = sprintf(
            "<info>[%s]</info> %s - <comment>%s</comment>",
            $issue->getKey(),
            $issue->get('summary'),
            $issue->get('status')['name']
        );

        return $header;
    }

    /**
     * Format comment section
     *
     * @param                 $issue
     *
     * @return array
     */
    protected function printComments($issue)
    {
        $lines = [];

        $lines[] = '<comment>Comments:</comment>';

        $comments = $issue->get('comment')['comments'];
        foreach ($comments as $comment) {
            $lines[] = "<comment>- {$comment['body']}</comment>";
            $lines[] = self::COMMENT_SEPARATOR;
        }

        return $lines;
    }

}
