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
class Project extends Model
{
	protected $id, $key, $name, $rate;
	protected $fillable = ['key', 'name', 'rate'];


	/**
	 * @param mixed $key
	 */
	public function setKey($key)
	{
		$this->key = $key;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name){
		$this->name = $name;
	}

	/**
	 * @param mixed $rate
	 */
	public function setRate($rate)
	{
		$this->rate = $rate;
	}


	/**
	 * @return ProjectService - для работы с API
	 */
	private static function apiProject() {
		return new  ProjectService();
	}

	/**
	 * @return UserService для работы с API
	 */
	private static function apiUser() {
		return new  UserService();
	}

	public static function getByKey($key)
	{
		$project = self::apiProject()->get($key);
		$arrProjects=[];
			$paramArray = [
				'project' => $key,
				'startAt' => 0,
				'maxResults' => 50, //max 1000
			];
			$users = self::apiUser()->findAssignableUsers($paramArray);
				$arrProjects['users'] = $users;
				$arrProjects['project'] = $project;
		return $arrProjects;
	}

	public function getParams($agr, $key)
	{
		$obj = self::where("key",$agr)->first();

		if (!empty($obj)){
			return $obj->attributes[$key];

		}else{
			return null;
		}


	}

	public function getAllInfo(){
		$arrProjects =[];

		$projects = self::apiProject()->getAllProjects();
		foreach ($projects as $project){
			$projectInfo = self::apiProject()->get($project->key);
			$paramArray = [
				'project' => $project->key,
				'startAt' => 0,
				'maxResults' => 50
			];
			$users = self::apiUser()->findAssignableUsers($paramArray);
			$arrProjects[$project->key] = [
				'project' => $projectInfo,
				'users' => $users,
				'rate' => self::getParams($project->key, 'rate')

			];

		}
		return $arrProjects;
	}

	public static function convert($agr, $size = '48x48') {
		$new = (array) $agr;

		return $new[$size];
	}

	public static function instance() {
		return new Project();
	}
}
