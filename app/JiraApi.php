<?php
/**
 * Класс для работы с Jira API
 */

namespace App;
use Illuminate\Http\Request;
use JiraRestApi\Group\GroupService;
use JiraRestApi\Project\ProjectService;
use JiraRestApi\JiraException;
use JiraRestApi\Configuration\ArrayConfiguration;
use JiraRestApi\Field\Field;
use JiraRestApi\Field\FieldService;
use JiraRestApi\User\UserService;
use App\Http\Controllers;

class JiraApi
{
	/**
	 *
	 * $jiraHost - адрес Jira
	 * $jiraUser - логин в jira
	 * $jiraPassword - токен в Jira
	 */
	private $jiraHost = 'https://webberry.atlassian.net';
	private $jiraUser = 'dl@webberry.ru';
	private $jiraPassword = 'LT3Rn5voDqd6C10SPvmXA7B9';

	private static function Instance(){
		return new self();
	}

	public static function Configs(){
		$oApi = self::Instance();
		return new ArrayConfiguration(
			array(
				'jiraHost' => $oApi->jiraHost,
				'jiraUser' => $oApi->jiraUser,
				'jiraPassword' => $oApi->jiraPassword,

			)
		);
	}

	/**
	 * @param $key - Уникальный ключ проекта в Jira
	 * @return bool|\JiraRestApi\Project\Project|object - Если запрос успешный отдает обьект Project иначе, false
	 */
	public static function getProjectByKey($key)
	{
		try {
			$oProject = new ProjectService(self::Configs());
				$projectInfo = $oProject->get($key);

		} catch (JiraException $e) {
			$projectInfo = false;
		}

		return $projectInfo;
	}

	/**
	 * @return bool|\JiraRestApi\Project\Project[] Если запрос успешный отдает массив обьектов Project иначе, false
	 */
	public static function getAllProject()
	{
		try {
			$oProjects = new ProjectService(self::Configs());
			$projects = $oProjects->getAllProjects();

		} catch (JiraException $e) {
			$projects = false;
		}

		return $projects;
	}

	/**
	 * @param $key - Уникальный ключ проекта в Jira
	 * @return bool|\JiraRestApi\User\User[] - Если запрос успешный отдает массив обьектов User иначе, false
	 */
	public static function getAllUsersInProjectByKey($key)
	{
		$us = new UserService(self::Configs());
		$paramArray = [
			//'username' => null,
			'project' => $key,
			//'issueKey' => 'TEST-1',
			'startAt' => 0,
			'maxResults' => 50, //max 1000
			//'actionDescriptorId' => 1,
		];
		try {

			$users = $us->findAssignableUsers($paramArray);

		} catch (JiraException $e) {
			$users = false;
		}

		return $users;
	}


}
