## jira-cli

[![Latest Stable Version](https://poser.pugx.org/chaseconey/jira-cli/v/stable)](https://packagist.org/packages/chaseconey/jira-cli) [![Total Downloads](https://poser.pugx.org/chaseconey/jira-cli/downloads)](https://packagist.org/packages/chaseconey/jira-cli) [![Latest Unstable Version](https://poser.pugx.org/chaseconey/jira-cli/v/unstable)](https://packagist.org/packages/chaseconey/jira-cli) [![License](https://poser.pugx.org/chaseconey/jira-cli/license)](https://packagist.org/packages/chaseconey/jira-cli)

A very simple command-line interface to your Jira instance.

*In Development*

### Quickstart

*As of right now, these lines are required in your global composer json due to dependency issue*

```json
	{
		"minimum-stability": "dev",
		"prefer-stable": true
	}
```

* Install globally via composer

`composer global require "chaseconey/jira-cli=~0.1"`

* Initialize config file

`jira init`

* Setup necessary config options (all are required)

`vim ~/.jira-cli/.env`

* Run commands!

### Example commands

Perform full-text searches through the search command:

`jira search "some interesting search"`

Get detailed information about a specific issue:

`jira key PROJ-1`

Get detailed information with all of the associated comments:

`jira key PROJ-1 --comments`
