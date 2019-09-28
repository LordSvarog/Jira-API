<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JiraRestApi\JiraException;
use JiraRestApi\User\UserService;

class Developers extends Model
{
    private static function api() {
        return new  UserService();
    }

    public static function getAll() {
        $paramArray = [
            'username' => '', // get all users.
//                'startAt' => 0,
//                'maxResults' => 1000,
//                'includeInactive' => true,
            //'property' => '*',
        ];

        return self::api()->findUsers($paramArray);

    }
}
