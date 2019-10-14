<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\JiraClient;
use JiraRestApi\JiraException;
use JiraRestApi\User\UserService;

class Developer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'name', 'position_id'];

    /**
     * @return UserService
     * @throws JiraException
     */
    private static function apiUser()
    {
        return new  UserService();
    }

    /**
     * @return IssueService
     * @throws JiraException
     */
    private static function apiIssue()
    {
        return new IssueService();
    }

    /*
     * Get all users from Jira
     */
    public static function getAll()
    {
        $paramArray = [
            'username' => '', // get all users.
        ];

        return self::apiUser()->findUsers($paramArray);
    }

    public static function getIssue($userKey)
    {
        $jql = 'assignee = '.$userKey.' and status = Done ORDER BY created DESC';
        return self::apiIssue()->search($jql);
    }
    /**
     * Получить данные из таблицы `positions`
     */
    public function position()
    {
        return $this->hasOne(Position::class, 'id', 'position_id');
    }
}
