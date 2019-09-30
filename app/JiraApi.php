<?php
/**
 * Класс для работы с Jira API
 */

namespace App;
use Illuminate\Database\Eloquent\Model;
use JiraRestApi\Project\ProjectService;


class JiraApi extends Model
{
	private static function apiProject() {
		return new  ProjectService();
	}
}
