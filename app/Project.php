<?php
/**
 * Модель для работы с JiraApi
 */
namespace App;

use Illuminate\Database\Eloquent\Model;
use JiraRestApi\Project\ProjectService;
use JiraRestApi\JiraException;
use JiraRestApi\Configuration\ArrayConfiguration;
use JiraRestApi\User\UserService;
class project extends Model
{

	protected $id, $key, $name, $paid, $rate,$users;

	function __construct($data = null)
	{
		if(!empty($data)) {

			if (!empty($data['id'])){

				$this->id = $data['id'];
				$this->key = $data['key'];
				$this->name = $data['name'];
				$this->paid = $data['paid'];
				$this->hours = $data['hours'];
				$this->rate = $data['rate'];
				$this->users = $data['users'];

			}else{
				$this->users_id = $data['users_id'];
				$this->report_time_id = $data['report_time_id'];
				$this->rate = $data['rate'];
			}


		}

	}

	public static function getProjectJiraApiByKey($key)
	{

		$proj = new ProjectService(new ArrayConfiguration(
			array(
				'jiraHost' => 'https://webberry.atlassian.net',
				// for basic authorization:
				'jiraUser' => 'dl@webberry.ru',
				'jiraPassword' => 'LT3Rn5voDqd6C10SPvmXA7B9',

			)
		));
		$arrProjects=[];
		$projectInfo = $proj->get($key);
		try {
			$us = new UserService();

			$paramArray = [
				'project' => $key,
				'startAt' => 0,
				'maxResults' => 50, //max 1000
			];

			$users = $us->findAssignableUsers($paramArray);
			foreach ($users as $user){
				$arrProjects[$key]['users'][$user->key] = $user;
				$arrProjects[$key]['project'] = $projectInfo;


			}

		} catch (JiraException $e) {
			print("Error Occured! " . $e->getMessage());
		}



		return $arrProjects;
	}



	public static function getAllProjectJiraApi()
	{

		$arrProjects =[];
		try {
			$proj = new ProjectService(new ArrayConfiguration(
				array(
					'jiraHost' => 'https://webberry.atlassian.net',
					// for basic authorization:
					'jiraUser' => 'dl@webberry.ru',
					'jiraPassword' => 'LT3Rn5voDqd6C10SPvmXA7B9',

				)
			));

			$pt = $proj->getAllProjects();


			foreach ($pt as $p){
				$projectInfo = $proj->get($p->key);
				//print_r($projectInfo->lead["displayName"]);
				try {
					$us = new UserService();

					$paramArray = [
						//'username' => null,
						'project' => $p->key,
						//'issueKey' => 'TEST-1',
						'startAt' => 0,
						'maxResults' => 50, //max 1000
						//'actionDescriptorId' => 1,
					];

					$users = $us->findAssignableUsers($paramArray);
					foreach ($users as $user){
						$arrProjects[$p->key]['users'][$user->key] = $user;
						$arrProjects[$p->key]['project'] = $projectInfo;


					}

				} catch (JiraException $e) {
					print("Error Occured! " . $e->getMessage());
				}

			}
		} catch (JiraException $e) {
			print("Error Occured! " . $e->getMessage());
		}



		return $arrProjects;
	}




}
