<?php

namespace App;

use chobie\Jira\Api;
use chobie\Jira\Api\Authentication\Basic;
use Symfony\Component\Console\Command\Command;

abstract class JiraCommand extends Command
{

    const COMMENT_SEPARATOR = '-------------------------------------------';

    /**
     * Get an instance of the Jira API Class
     *
     * @return Api
     */
    protected function getApi()
    {
        $api = new Api(
            getenv('JIRA_URL'),
            new Basic(getenv('JIRA_USERNAME'), getenv('JIRA_PASSWORD'))
        );

        return $api;
    }
}
