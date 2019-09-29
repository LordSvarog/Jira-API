<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\JiraClient;
use JiraRestApi\JiraException;
use JiraRestApi\User\UserService;

class Developers extends Model
{
    private static function apiUser() {
        return new  UserService();
    }

    private static function apiIssue() {
        return new IssueService();
    }

    /*
     * Get all users from Jira
     */
    public static function getAll() {
        $paramArray = [
            'username' => '', // get all users.
        ];

        return self::apiUser()->findUsers($paramArray);
    }

    public static function getIssue($userKey) {
        $jql = 'assignee = '.$userKey.' and status = Done ORDER BY created DESC';
        return self::apiIssue()->search($jql);
    }
}
